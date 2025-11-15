<?php
// Generar hash de la contraseña Thellsol2314
$password = 'Thellsol2314';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "<h1>🔐 Hash Generado</h1>";
echo "<hr>";
echo "<h2>Contraseña:</h2>";
echo "<p style='background: #f0f0f0; padding: 10px; border-radius: 5px; font-family: monospace; font-size: 18px;'>" . htmlspecialchars($password) . "</p>";

echo "<h2>Hash para pegar en phpMyAdmin:</h2>";
echo "<p style='background: #e8f5e9; padding: 15px; border-radius: 5px; font-family: monospace; word-break: break-all; font-size: 14px; border: 2px solid #4caf50;'>" . htmlspecialchars($hash) . "</p>";

echo "<hr>";
echo "<h2>📋 Instrucciones:</h2>";
echo "<ol style='line-height: 2; font-size: 16px;'>";
echo "<li>Copia el hash de arriba (el texto verde)</li>";
echo "<li>Ve a phpMyAdmin → Tabla <code>admin_users</code></li>";
echo "<li>Haz clic en <strong>Editar</strong> en la fila del usuario <code>andre</code></li>";
echo "<li>En el campo <code>password_hash</code>, <strong>borra</strong> el texto plano y <strong>pega</strong> el hash</li>";
echo "<li>Haz clic en <strong>Continuar</strong> o <strong>Guardar</strong></li>";
echo "<li>¡Listo! Ahora puedes iniciar sesión con: <code>andre@thellsol.com</code> / <code>Thellsol2314</code></li>";
echo "</ol>";

// Verificar que funciona
echo "<hr>";
echo "<h2>✅ Verificación:</h2>";
if (password_verify($password, $hash)) {
    echo "<p style='color: green; font-size: 18px;'>✓ El hash es correcto y funcionará con password_verify()</p>";
} else {
    echo "<p style='color: red; font-size: 18px;'>✗ Error en el hash</p>";
}
?>

