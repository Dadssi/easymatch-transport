CREATE DATABASE easymatch;
-- ========================================
-- 1- USERS ===============================
-- ========================================
CREATE TYPE user_role AS ENUM ('sender', 'driver', 'admin');

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,  -- Mot de passe haché
    phone VARCHAR(20) UNIQUE NOT NULL,
    birthday DATE NOT NULL,
    role user_role NOT NULL,
    vehicle_category_id INT REFERENCES vehicle_categories(id),
    is_verified BOOLEAN DEFAULT FALSE, -- Badge "Vérifié"
    is_banned BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- ========================================
-- 2- VEHICLE CATEGORIES ==================
-- ========================================
CREATE TABLE vehicle_categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL, -- Nom de la catégorie (Ex: "Économique", "Camionnette", "Camion", "Remorque")
    max_volume FLOAT NOT NULL -- Volume max en m³
);
-- ========================================
-- 3- ANNOUNCEMENTS =======================
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
-- 4- ANNOUNCEMENTS STOPS =================
-- ========================================
CREATE TABLE announcement_stops (
    id SERIAL PRIMARY KEY,
    announcement_id INT REFERENCES driver_announcements(id) ON DELETE CASCADE,
    stop_order INT NOT NULL, -- Ordre des étapes (1 = première ville intermédiaire, 2 = deuxième...)
    city VARCHAR(100) NOT NULL
);
-- ========================================
-- 5- PACKAGES ============================
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
-- 6- PACKAGES TYPES ======================
-- ========================================
CREATE TABLE package_types (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL -- Ex: Fragile, Alimentaire, Électronique, etc.
);
-- ========================================
-- 7- ANNOUNCEMENT ALLOWED PACKAGES TYPES =
-- ========================================
CREATE TABLE announcement_allowed_packages (
    announcement_id INT REFERENCES driver_announcements(id) ON DELETE CASCADE,
    package_type_id INT REFERENCES package_types(id) ON DELETE CASCADE,
    PRIMARY KEY (announcement_id, package_type_id) -- Évite les doublons
);
-- ========================================
-- 8- LOGS ================================
-- ========================================
CREATE TABLE logs (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) ON DELETE SET NULL,
    action TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);