<?php
// CONFIGURACIÓN DE USUARIOS CON MYSQL
session_start();
require_once 'db-config.php';

// Función para verificar credenciales desde MySQL
function verify_user($email, $password) {
    $conn = getDBConnection();
    
    // Buscar usuario por email
    $stmt = $conn->prepare("SELECT id, username, password_hash, email FROM admin_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verificar contraseña usando password_verify (compatible con password_hash)
        if (password_verify($password, $user['password_hash'])) {
            return [
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['username'],
                'role' => 'Admin' // Por defecto Admin, puedes agregar campo role a la tabla si lo necesitas
            ];
        }
    }
    
    $stmt->close();
    return false;
}

// Función para verificar si el usuario está logueado  
function is_logged_in() {
    return isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
}

// Función para hacer login
function login_user($user_data) {
    $_SESSION['user_logged_in'] = true;
    $_SESSION['user_data'] = $user_data;
    return true;
}

// Función para hacer logout
function logout_user() {
    session_destroy();
    return true;
}

// Función para requerir autenticación
function require_auth() {
    if (!is_logged_in()) {
        header('Location: admin-login.php');
        exit();
    }
    return $_SESSION['user_data'];
}
?>
