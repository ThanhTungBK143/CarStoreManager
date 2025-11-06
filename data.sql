CREATE DATABASE cardealer;
USE cardealer;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
INSERT INTO users (username, password)
VALUES 
('admin', MD5('12345'));
CREATE TABLE Cars (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    make VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year INT NOT NULL, 
    color VARCHAR(30) NOT NULL, 
    quantity INT NOT NULL,
    price DECIMAL(12, 2) NOT NULL
);
INSERT INTO Cars (make, model, year, color, quantity, price) 
VALUES
('VinFast', 'VF8', 2024, 'Red', 10, 1050000000.00),
('Toyota', 'Vios', 2023, 'Silver', 25, 520000000.00),
('Ford', 'Ranger', 2023, 'Orange', 15, 850000000.00),
('Hyundai', 'Creta', 2024, 'White', 20, 640000000.00),
('VinFast', 'VF9', 2024, 'Black', 5, 1490000000.00),
('Toyota', 'Camry', 2023, 'Black', 8, 1150000000.00),
('Ford', 'Everest', 2023, 'Blue', 12, 1200000000.00);