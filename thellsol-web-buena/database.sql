-- Tabla de propiedades
CREATE TABLE IF NOT EXISTS properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    type ENUM('apartment', 'villa', 'house', 'penthouse') NOT NULL,
    location VARCHAR(100) NOT NULL,
    bedrooms INT NOT NULL DEFAULT 0,
    bathrooms INT NOT NULL DEFAULT 0,
    area DECIMAL(8,2) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    status ENUM('active', 'inactive', 'sold') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de características de propiedades
CREATE TABLE IF NOT EXISTS features (
    id INT AUTO_INCREMENT PRIMARY KEY,
    property_id INT NOT NULL,
    feature_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE
);

-- Tabla de usuarios administradores (para futuras expansiones)
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de imágenes adicionales de propiedades
CREATE TABLE IF NOT EXISTS property_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    property_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE
);

-- Insertar algunos datos de ejemplo
INSERT INTO properties (title, price, type, location, bedrooms, bathrooms, area, description, status) VALUES
('Apartamento de lujo en Fuengirola', 350000.00, 'apartment', 'fuengirola', 3, 2, 120.50, 'Hermoso apartamento con vistas al mar, completamente equipado y en excelente ubicación.', 'active'),
('Villa moderna en Benalmádena', 850000.00, 'villa', 'benalmadena', 4, 3, 280.00, 'Villa de lujo con piscina privada, jardín y garaje para 2 coches.', 'active'),
('Casa adosada en Mijas', 420000.00, 'house', 'mijas', 3, 2, 150.00, 'Casa adosada en urbanización tranquila con piscina comunitaria.', 'active'),
('Ático con vistas al mar', 580000.00, 'penthouse', 'torremolinos', 2, 2, 95.00, 'Ático de lujo con terraza privada y vistas panorámicas al mar.', 'active');

-- Insertar características para las propiedades de ejemplo
INSERT INTO features (property_id, feature_name) VALUES
(1, 'pool'), (1, 'garden'), (1, 'airConditioning'), (1, 'elevator'),
(2, 'pool'), (2, 'garden'), (2, 'garage'), (2, 'terrace'), (2, 'airConditioning'),
(3, 'garden'), (3, 'terrace'), (3, 'heating'),
(4, 'terrace'), (4, 'airConditioning'), (4, 'seaView'), (4, 'elevator');

-- Crear índices para mejorar el rendimiento
CREATE INDEX idx_properties_location ON properties(location);
CREATE INDEX idx_properties_type ON properties(type);
CREATE INDEX idx_properties_status ON properties(status);
CREATE INDEX idx_properties_price ON properties(price);
CREATE INDEX idx_features_property ON features(property_id); 