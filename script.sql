-- Create users table to store information about all users (senders, drivers, and admin)
CREATE TABLE users (
    user_id SERIAL PRIMARY KEY,
    first_name VARCHAR(50) UNIQUE NOT NULL,
    last_name VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role VARCHAR(20) CHECK (role IN ('sender', 'driver', 'admin')) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create vehicles table to store information about drivers' vehicles
CREATE TABLE vehicles (
    vehicle_id SERIAL PRIMARY KEY,
    driver_id INTEGER REFERENCES users(user_id) ON DELETE CASCADE,
    vehicle_type VARCHAR(50) NOT NULL,
    carry_size INTEGER NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create routes table to store route information
CREATE TABLE routes (
    route_id SERIAL PRIMARY KEY,
    driver_id INTEGER REFERENCES users(user_id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create route_points table to store the cities in a route
CREATE TABLE route_points (
    route_point_id SERIAL PRIMARY KEY,
    route_id INTEGER REFERENCES routes(route_id) ON DELETE CASCADE,
    city VARCHAR(50) NOT NULL,
    sequence INTEGER NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create driver_announcements table to store announcements made by drivers
CREATE TABLE driver_announcements (
    announcement_id SERIAL PRIMARY KEY,
    driver_id INTEGER REFERENCES users(user_id) ON DELETE CASCADE,
    vehicle_id INTEGER REFERENCES vehicles(vehicle_id) ON DELETE CASCADE,
    route_id INTEGER REFERENCES routes(route_id) ON DELETE CASCADE,
    available_from TIMESTAMP NOT NULL,
    available_until TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create sender_requests table to store requests made by senders
CREATE TABLE sender_requests (
    request_id SERIAL PRIMARY KEY,
    sender_id INTEGER REFERENCES users(user_id) ON DELETE CASCADE,
    announcement_id INTEGER REFERENCES driver_announcements(announcement_id) ON DELETE CASCADE,
    package_size INTEGER NOT NULL,
    pickup_city VARCHAR(50) NOT NULL,
    dropoff_city VARCHAR(50) NOT NULL,
    status VARCHAR(20) CHECK (status IN ('pending', 'accepted', 'rejected', 'completed')) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Example data insertion
INSERT INTO users (username, password, email, role) VALUES
('driver1', 'password1', 'driver1@example.com', 'driver'),
('sender1', 'password2', 'sender1@example.com', 'sender'),
('admin1', 'password3', 'admin1@example.com', 'admin');

INSERT INTO vehicles (driver_id, vehicle_type, carry_size) VALUES
(1, 'van', 1000);

INSERT INTO routes (driver_id) VALUES
(1);

INSERT INTO route_points (route_id, city, sequence) VALUES
(1, 'City A', 1),
(1, 'City B', 2),
(1, 'City C', 3),
(1, 'City D', 4),
(1, 'City E', 5),
(1, 'City F', 6);

INSERT INTO driver_announcements (driver_id, vehicle_id, route_id, available_from, available_until) VALUES
(1, 1, 1, '2025-02-16 08:00:00', '2025-02-16 20:00:00');

INSERT INTO sender_requests (sender_id, announcement_id, package_size, pickup_city, dropoff_city) VALUES
(2, 1, 500, 'City B', 'City C');