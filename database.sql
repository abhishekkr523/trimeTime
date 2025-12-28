-- ================================
-- Database: Barber Booking System
-- ================================

DROP DATABASE IF EXISTS barber_booking;
CREATE DATABASE barber_booking;
USE barber_booking;

-- ================================
-- Users Table
-- ================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('barber','client') NOT NULL,

    shop_name VARCHAR(150) NULL,
    address TEXT NULL,
    contact_number VARCHAR(20) NULL,
    opening_hours VARCHAR(100) NULL,
    price_range VARCHAR(50) NULL,
    profile_image VARCHAR(255) NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ================================
-- Services Table
-- ================================
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    barber_id INT NOT NULL,
    service_name VARCHAR(150) NOT NULL,
    price DECIMAL(10,2) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_services_barber
        FOREIGN KEY (barber_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

-- ================================
-- Appointments Table
-- ================================
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    barber_id INT NOT NULL,
    service_id INT NOT NULL,

    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,

    status ENUM('pending','approved','cancelled','completed') 
           DEFAULT 'pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_appointments_client
        FOREIGN KEY (client_id)
        REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_appointments_barber
        FOREIGN KEY (barber_id)
        REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_appointments_service
        FOREIGN KEY (service_id)
        REFERENCES services(id)
        ON DELETE CASCADE
);

-- ================================
-- Favorites Table
-- ================================
CREATE TABLE favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    barber_id INT NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY unique_favorite (client_id, barber_id),

    CONSTRAINT fk_favorites_client
        FOREIGN KEY (client_id)
        REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_favorites_barber
        FOREIGN KEY (barber_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

-- ================================
-- Indexes (Performance)
-- ================================
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_services_barber ON services(barber_id);
CREATE INDEX idx_appointments_barber ON appointments(barber_id);
CREATE INDEX idx_appointments_client ON appointments(client_id);

-- ================================
-- DONE
-- ================================
