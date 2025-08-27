<?php
// CONFIGURACIÓN SIMPLE DE USUARIOS
session_start();

// Usuarios autorizados (sistema simple)
$users = [
    'andre@thellsol.com' => [
        'password' => 'ThellSol2025!', 
        'name' => 'Andre Tell', 
        'role' => 'Admin'
    ],
    'cliente@thellsol.com' => [
        'password' => 'Cliente2025!', 
        'name' => 'Cliente', 
        'role' => 'Editor'
    ]
];

// Función para verificar credenciales
function verify_user($email, $password) {
    global $users;
    
    if (isset($users[$email]) && $users[$email]['password'] === $password) {
        return [
            'email' => $email,
            'name' => $users[$email]['name'],
            'role' => $users[$email]['role']
        ];
    }
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
