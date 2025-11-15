<?php
// CONFIGURACIÓN DE BASE DE DATOS MYSQL - HOSTINGER
// Archivo: db-config.php

// Credenciales de MySQL en Hostinger
define('DB_HOST', 'localhost');
define('DB_USER', 'u337903245_admin');
define('DB_PASS', 'Thellsol2314');
define('DB_NAME', 'u337903245_thellsol');

// Función para obtener conexión a la base de datos
function getDBConnection() {
    static $conn = null;
    
    if ($conn === null) {
        try {
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            // Verificar conexión
            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }
            
            // Establecer charset UTF-8
            $conn->set_charset("utf8mb4");
            
        } catch (Exception $e) {
            die("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }
    
    return $conn;
}

// Función para cerrar conexión (opcional, PHP cierra automáticamente)
function closeDBConnection($conn) {
    if ($conn && !$conn->connect_error) {
        $conn->close();
    }
}

?>

