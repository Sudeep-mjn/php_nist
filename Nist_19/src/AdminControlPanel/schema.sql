-- NIST19 Admin Panel Database Schema

-- Create database
CREATE DATABASE IF NOT EXISTS nist19_admin;
USE nist19_admin;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'super_admin') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Notices table
CREATE TABLE IF NOT EXISTS notices (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date DATE NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Activities table
CREATE TABLE IF NOT EXISTS activities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image_url TEXT,
    link TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default admin user (password: Admin@1)
INSERT INTO users (username, password, role) VALUES 
('admin@gmail.com', '$2y$10$YourHashedPasswordHere', 'super_admin')
ON DUPLICATE KEY UPDATE username = username;

-- Sample notices
INSERT INTO notices (title, description, date) VALUES 
('Market Holiday', 'The stock market will remain closed on November 23rd due to national holiday.', '2023-11-23'),
('New Trading Policy', 'SEBON has introduced new trading policies effective from December 1st, 2023.', '2023-12-01'),
('System Maintenance', 'Our online trading platform will be unavailable for maintenance on November 25th from 10 PM to 2 AM.', '2023-11-25'),
('Investor Workshop', 'Join our free investor education workshop on December 15th, 2023.', '2023-12-15');

-- Sample activities
INSERT INTO activities (title, description, image_url, link) VALUES 
('Annual General Meeting', 'NIST19 Annual General Meeting will be held on December 20th, 2023. All shareholders are invited to participate.', '', 'https://example.com/agm'),
('New Office Opening', 'We are excited to announce the opening of our new branch office in Pokhara.', '', 'https://example.com/new-office'),
('Financial Literacy Program', 'Free financial literacy program for students and young professionals.', '', 'https://example.com/literacy-program');
