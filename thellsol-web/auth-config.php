<?php
// CONFIGURACIÓN DE USUARIOS AUTORIZADOS
// Este archivo contiene las credenciales de acceso al dashboard

// Array de usuarios autorizados
$authorized_users = [
    // Usuario principal (Andre)
    [
        'username' => 'andre',
        'email' => 'andre@thellsol.com',
        'password' => password_hash('ThellSol2025!', PASSWORD_DEFAULT), // Cambiar por tu contraseña deseada
        'role' => 'admin',
        'name' => 'Andre Richard Tell'
    ],
    // Usuario cliente
    [
        'username' => 'cliente',
        'email' => 'cliente@thellsol.com', 
        'password' => password_hash('Cliente2025!', PASSWORD_DEFAULT), // Cambiar por contraseña del cliente
        'role' => 'editor',
        'name' => 'Cliente TellSol'
    ]
];

// Configuración de sesión
$session_timeout = 3600; // 1 hora en segundos
$session_name = 'thellsol_admin_session';

// Función para verificar credenciales
function verify_user($email, $password) {
    global $authorized_users;
    
    foreach ($authorized_users as $user) {
        if ($user['email'] === $email && password_verify($password, $user['password'])) {
            return [
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role'],
                'name' => $user['name']
            ];
        }
    }
    return false;
}

// Función para verificar si el usuario está logueado
function is_logged_in() {
    global $session_name, $session_timeout;
    
    if (!isset($_SESSION)) {
        session_name($session_name);
        session_start();
    }
    
    // Verificar si existe la sesión y no ha expirado
    if (isset($_SESSION['user_logged_in']) && 
        isset($_SESSION['login_time']) && 
        (time() - $_SESSION['login_time']) < $session_timeout) {
        
        // Renovar tiempo de sesión
        $_SESSION['login_time'] = time();
        return $_SESSION['user_data'];
    }
    
    return false;
}

// Función para hacer login
function login_user($user_data) {
    global $session_name;
    
    if (!isset($_SESSION)) {
        session_name($session_name);
        session_start();
    }
    
    $_SESSION['user_logged_in'] = true;
    $_SESSION['user_data'] = $user_data;
    $_SESSION['login_time'] = time();
    
    return true;
}

// Función para hacer logout
function logout_user() {
    global $session_name;
    
    if (!isset($_SESSION)) {
        session_name($session_name);
        session_start();
    }
    
    // Limpiar todas las variables de sesión
    $_SESSION = array();
    
    // Destruir la cookie de sesión
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destruir la sesión
    session_destroy();
    
    return true;
}

// Función para requerir autenticación
function require_auth() {
    $user = is_logged_in();
    if (!$user) {
        // Redirigir al login
        header('Location: admin-login.php');
        exit();
    }
    return $user;
}
?>
