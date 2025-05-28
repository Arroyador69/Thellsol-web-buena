-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS thellsol_db;
USE thellsol_db;

-- Tabla de propiedades
CREATE TABLE IF NOT EXISTS properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    type VARCHAR(50) NOT NULL,
    location VARCHAR(100) NOT NULL,
    bedrooms INT NOT NULL,
    bathrooms INT NOT NULL,
    area DECIMAL(10,2) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de características
CREATE TABLE IF NOT EXISTS features (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Tabla de relación entre propiedades y características
CREATE TABLE IF NOT EXISTS property_features (
    property_id INT,
    feature_id INT,
    PRIMARY KEY (property_id, feature_id),
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    FOREIGN KEY (feature_id) REFERENCES features(id) ON DELETE CASCADE
);

-- Insertar características básicas
INSERT INTO features (name) VALUES 
('Piscina'),
('Jardín'),
('Garaje'),
('Terraza'),
('Aire acondicionado'),
('Calefacción'),
('Ascensor'),
('Seguridad 24h'),
('Vistas al mar'),
('Mobiliario incluido')
ON DUPLICATE KEY UPDATE name = VALUES(name); 