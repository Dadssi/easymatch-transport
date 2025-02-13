-- ========================================
-- 0- DATABASE ===============================
-- ========================================
CREATE DATABASE  easymatch;

-- ========================================
-- 1- CRÉATION DU TYPE ENUM user_role =====
-- ========================================
CREATE TYPE user_role AS ENUM ('sender', 'driver', 'admin');

-- ========================================
 -- 2- CRÉATION DE LA TABLE vehicle_categories
-- ========================================
CREATE TABLE vehicle_categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL, -- Nom de la catégorie (Ex: "Économique", "Camionnette", "Camion", "Remorque")
    max_volume FLOAT NOT NULL -- Volume max en m³
);
-- ========================================
-- 3- CRÉATION DE LA TABLE users ==========
-- ========================================
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, 
    phone VARCHAR(20) UNIQUE NOT NULL,
    birthday DATE NOT NULL,
    role user_role NOT NULL,  -- Le type user_role doit exister avant cette ligne
    vehicle_category_id INT REFERENCES vehicle_categories(id), 
    is_verified BOOLEAN DEFAULT FALSE, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========================================
-- 4- ANNOUNCEMENTS =======================
-- ========================================
CREATE TABLE driver_announcements (
    id SERIAL PRIMARY KEY,
    driver_id INT REFERENCES users(id) ON DELETE CASCADE,
    vehicle_category_id INT REFERENCES vehicle_categories(id),
    total_volume FLOAT NOT NULL, -- Volume total du véhicule (récupéré depuis `vehicle_categories`)
    available_volume FLOAT NOT NULL, -- Volume libre (mis à jour après chaque transaction)
    departure_city VARCHAR(100) NOT NULL,
    arrival_city VARCHAR(100) NOT NULL,
    departure_date TIMESTAMP NOT NULL,
    status VARCHAR(20) CHECK (status IN ('pending','accepted', 'completed', 'cancelled')) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- ========================================
-- 5- ANNOUNCEMENTS STOPS =================
-- ========================================
CREATE TABLE announcement_stops (
    id SERIAL PRIMARY KEY,
    announcement_id INT REFERENCES announcements(id) ON DELETE CASCADE,
    stop_order INT NOT NULL, -- Ordre des étapes (1 = première ville intermédiaire, 2 = deuxième...)
    city VARCHAR(100) NOT NULL
);
-- ========================================
-- 6- PACKAGES ============================
-- ========================================
CREATE TABLE packages (
    id SERIAL PRIMARY KEY,
    sender_id INT REFERENCES users(id) ON DELETE CASCADE,
    driver_announcement_id INT REFERENCES driver_announcements(id) ON DELETE CASCADE,
    description TEXT NOT NULL,
    weight INT NOT NULL,
    dimensions VARCHAR(50) NOT NULL, -- Format: "LxWxH cm"
    package_type VARCHAR(50) NOT NULL,
    status VARCHAR(20) CHECK (status IN ('pending', 'accepted', 'delivered', 'cancelled')) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- ========================================
-- 7- PACKAGES TYPES ======================
-- ========================================
CREATE TABLE package_types (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL -- Ex: Fragile, Alimentaire, Électronique, etc.
);
-- ========================================
-- 8- ANNOUNCEMENT ALLOWED PACKAGES TYPES =
-- ========================================
CREATE TABLE announcement_allowed_packages (
    announcement_id INT REFERENCES announcements(id) ON DELETE CASCADE,
    package_type_id INT REFERENCES package_types(id) ON DELETE CASCADE,
    PRIMARY KEY (announcement_id, package_type_id) -- Évite les doublons
);
-- ========================================
-- 9- LOGS ================================
-- ========================================
CREATE TABLE logs (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) ON DELETE SET NULL,
    action TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- comment


-- Drop tables if they exist (to start fresh)
DROP TABLE IF EXISTS logs, verifications, routes, shipments, announcements, users CASCADE;
 
-- User Table

 
-- Logs Table (for system logs, viewed by admins)

 
-- Announcement Table (driver posts available transport routes)
CREATE TABLE announcements (
    id SERIAL PRIMARY KEY,
    driver_id INT REFERENCES users(id) ON DELETE CASCADE,
    
    start_city VARCHAR(100) NOT NULL,
    end_city VARCHAR(100) NOT NULL,
    travel_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
 
-- Routes Table (for step-by-step driver's itinerary between start and end city)
CREATE TABLE routes (
    id SERIAL PRIMARY KEY,
    announcement_id INT REFERENCES announcements(id) ON DELETE CASCADE,
    driver_id INT REFERENCES users(id) ON DELETE CASCADE,
    stop_city VARCHAR(100) NOT NULL,
    step_order INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
 
-- Shipment Table (for storing package details)
CREATE TABLE shipments (
    id SERIAL PRIMARY KEY,
    sender_id INT REFERENCES users(id) ON DELETE CASCADE,
    driver_id INT REFERENCES users(id) ON DELETE CASCADE,
    announcement_id INT REFERENCES announcements(id) ON DELETE CASCADE,
    dimensions JSONB NOT NULL,  -- Ex: {"length": 50, "width": 30, "height": 20}
    weight DECIMAL(10,2) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    status VARCHAR(20) CHECK (status IN ('pending', 'accepted', 'shipped', 'delivered')) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
 
-- Verification Table (for ID verification process)
CREATE TABLE verifications (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    id_card_path TEXT NOT NULL,  -- Path to stored ID image file
    status VARCHAR(20) CHECK (status IN ('pending', 'verified', 'rejected')) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===================================

-- Insertion des catégories de véhicules
INSERT INTO vehicle_categories (name, max_volume) VALUES
('Économique', 3.0),
('Camionnette', 6.0),
('Camion', 15.0),
('Remorque', 30.0);

-- Insertion des utilisateurs
INSERT INTO users (first_name, last_name, email, password, phone, birthday, role, vehicle_category_id, is_verified) VALUES
('Ali', 'Ben', 'ali.ben@example.com', 'hashedpassword1', '0600000001', '1990-05-15', 'driver', 2, TRUE),
('Sami', 'Lopez', 'sami.lopez@example.com', 'hashedpassword2', '0600000002', '1985-08-22', 'sender', NULL, TRUE),
('Admin', 'System', 'admin@example.com', 'hashedpassword3', '0600000003', '1980-01-01', 'admin', NULL, TRUE);

-- Insertion des annonces des conducteurs
INSERT INTO driver_announcements (driver_id, vehicle_category_id, total_volume, available_volume, departure_city, arrival_city, departure_date, status) VALUES
(1, 2, 6.0, 6.0, 'Casablanca', 'Marrakech', '2025-03-10 08:00:00', 'pending');

-- Insertion des arrêts intermédiaires
INSERT INTO announcement_stops (announcement_id, stop_order, city) VALUES
(1, 1, 'Settat'),
(1, 2, 'Ben Guerir');

-- Insertion des types de colis
INSERT INTO package_types (name) VALUES
('Fragile'),
('Alimentaire'),
('Électronique');

-- Insertion des colis
INSERT INTO packages (sender_id, driver_announcement_id, description, weight, dimensions, package_type, status) VALUES
(2, 1, 'Petit paquet fragile', 5, '30x20x15 cm', 'Fragile', 'pending');

-- Insertion des types de colis autorisés par annonce
INSERT INTO announcement_allowed_packages (announcement_id, package_type_id) VALUES
(1, 1),
(1, 2);

-- Insertion des logs
INSERT INTO logs (user_id, action) VALUES
(1, 'Création d'une annonce'),
(2, 'Ajout d'un colis');

-- Insertion des annonces
INSERT INTO announcements (driver_id, start_city, end_city, travel_date) VALUES
(1, 'Casablanca', 'Tanger', '2025-03-15');

-- Insertion des étapes d'itinéraire
INSERT INTO routes (announcement_id, driver_id, stop_city, step_order) VALUES
(1, 1, 'Rabat', 1),
(1, 1, 'Kenitra', 2);

-- Insertion des expéditions
INSERT INTO shipments (sender_id, driver_id, announcement_id, dimensions, weight, destination, status) VALUES
(2, 1, 1, '{"length": 50, "width": 30, "height": 20}', 10.5, 'Tanger', 'pending');

-- Insertion des vérifications
INSERT INTO verifications (user_id, id_card_path, status) VALUES
(1, '/uploads/ids/ali_ben_id.jpg', 'verified');




