<?php
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'thellsol_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Configuración de sesión
session_start();

// Configuración de seguridad
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'thellsol2024!'); // Cambiar en producción

// Configuración de archivos
define('UPLOAD_DIR', 'uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
?> 