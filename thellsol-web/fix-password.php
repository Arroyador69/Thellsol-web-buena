<?php
// Script para generar hash y verificar contraseña
// Ejecuta este archivo desde el navegador: https://thellsol.com/fix-password.php

require_once 'db-config.php';

$conn = getDBConnection();

// Contraseña que quieres usar
$nuevaPassword = 'Thellsol2314';

// Generar hash
$hash = password_hash($nuevaPassword, PASSWORD_DEFAULT);

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Fix Password</title>";
echo "<style>body{font-family:Arial;max-width:800px;margin:50px auto;padding:20px;}";
echo ".hash-box{background:#e8f5e9;padding:20px;border:3px solid #4caf50;border-radius:8px;margin:20px 0;word-break:break-all;font-family:monospace;font-size:14px;}";
echo ".success{background:#d4edda;color:#155724;padding:15px;border-radius:5px;margin:10px 0;}";
echo ".error{background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;margin:10px 0;}";
echo ".btn{background:#667eea;color:white;padding:12px 24px;border:none;border-radius:5px;cursor:pointer;font-size:16px;margin:10px 5px;}";
echo ".btn:hover{background:#5a6fd8;}";
echo "pre{background:#f5f5f5;padding:15px;border-radius:5px;overflow-x:auto;}";
echo "</style></head><body>";

echo "<h1>🔐 Generador y Verificador de Contraseña</h1>";
echo "<hr>";

// Verificar usuario actual en la base de datos
$stmt = $conn->prepare("SELECT id, username, email, password_hash FROM admin_users WHERE username = 'andre'");
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    echo "<div class='success'>";
    echo "<h2>✅ Usuario encontrado:</h2>";
    echo "<p><strong>ID:</strong> " . htmlspecialchars($user['id']) . "</p>";
    echo "<p><strong>Username:</strong> " . htmlspecialchars($user['username']) . "</p>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($user['email']) . "</p>";
    echo "<p><strong>Hash actual:</strong> <code style='word-break:break-all;'>" . htmlspecialchars($user['password_hash']) . "</code></p>";
    echo "</div>";
    
    // Verificar si el hash actual funciona con la contraseña
    if (password_verify($nuevaPassword, $user['password_hash'])) {
        echo "<div class='success'>";
        echo "<h2>✅ La contraseña actual YA FUNCIONA</h2>";
        echo "<p>El hash en la base de datos es correcto para la contraseña: <strong>Thellsol2314</strong></p>";
        echo "<p>Puedes iniciar sesión con: <strong>andre@thellsol.com</strong> / <strong>Thellsol2314</strong></p>";
        echo "</div>";
    } else {
        echo "<div class='error'>";
        echo "<h2>❌ El hash actual NO funciona con la contraseña</h2>";
        echo "<p>Necesitas actualizar el hash en la base de datos.</p>";
        echo "</div>";
    }
} else {
    echo "<div class='error'>";
    echo "<h2>❌ Usuario 'andre' no encontrado</h2>";
    echo "</div>";
}

echo "<hr>";
echo "<h2>🔑 Hash Nuevo Generado:</h2>";
echo "<div class='hash-box'>";
echo "<strong>Contraseña:</strong> " . htmlspecialchars($nuevaPassword) . "<br><br>";
echo "<strong>Hash (copia esto):</strong><br>";
echo htmlspecialchars($hash);
echo "</div>";

// Si hay un parámetro ?update=1, actualizar directamente
if (isset($_GET['update']) && $_GET['update'] == '1') {
    $updateStmt = $conn->prepare("UPDATE admin_users SET password_hash = ? WHERE username = 'andre'");
    $updateStmt->bind_param("s", $hash);
    
    if ($updateStmt->execute()) {
        echo "<div class='success'>";
        echo "<h2>✅ ¡Contraseña actualizada exitosamente!</h2>";
        echo "<p>El hash se ha guardado en la base de datos.</p>";
        echo "<p>Ahora puedes iniciar sesión con: <strong>andre@thellsol.com</strong> / <strong>Thellsol2314</strong></p>";
        echo "</div>";
        
        // Verificar que funciona
        $verifyStmt = $conn->prepare("SELECT password_hash FROM admin_users WHERE username = 'andre'");
        $verifyStmt->execute();
        $verifyResult = $verifyStmt->get_result();
        $updatedUser = $verifyResult->fetch_assoc();
        
        if (password_verify($nuevaPassword, $updatedUser['password_hash'])) {
            echo "<div class='success'>";
            echo "<h3>✅ Verificación: El hash funciona correctamente</h3>";
            echo "</div>";
        }
    } else {
        echo "<div class='error'>";
        echo "<h2>❌ Error al actualizar: " . $conn->error . "</h2>";
        echo "</div>";
    }
    $updateStmt->close();
} else {
    echo "<h2>📋 Opciones:</h2>";
    echo "<p><strong>Opción 1:</strong> Copia el hash de arriba y pégalo manualmente en phpMyAdmin</p>";
    echo "<p><strong>Opción 2:</strong> Haz clic en el botón de abajo para actualizar automáticamente</p>";
    echo "<a href='?update=1' class='btn' onclick='return confirm(\"¿Estás seguro de actualizar la contraseña?\")'>🔄 Actualizar Contraseña Automáticamente</a>";
}

echo "<hr>";
echo "<h2>📝 SQL para ejecutar en phpMyAdmin (alternativa):</h2>";
echo "<p>Si prefieres usar SQL directamente, ejecuta esto en phpMyAdmin → SQL:</p>";
echo "<pre>";
echo "UPDATE admin_users \n";
echo "SET password_hash = '" . htmlspecialchars($hash) . "' \n";
echo "WHERE username = 'andre';";
echo "</pre>";

echo "</body></html>";
?>

