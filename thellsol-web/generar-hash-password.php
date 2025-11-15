<?php
// Script para generar hash de contraseña para MySQL
// Usa este archivo para generar el hash de una contraseña nueva

// CONTRASEÑA QUE QUIERES USAR (cámbiala aquí)
$nuevaPassword = 'TuNuevaContraseña123!';

// Generar hash usando password_hash (compatible con password_verify)
$hash = password_hash($nuevaPassword, PASSWORD_DEFAULT);

echo "<h1>🔐 Generador de Hash de Contraseña</h1>";
echo "<hr>";
echo "<h2>Contraseña original:</h2>";
echo "<p style='background: #f0f0f0; padding: 10px; border-radius: 5px; font-family: monospace;'>" . htmlspecialchars($nuevaPassword) . "</p>";

echo "<h2>Hash generado (copia esto en phpMyAdmin):</h2>";
echo "<p style='background: #e8f5e9; padding: 15px; border-radius: 5px; font-family: monospace; word-break: break-all; font-size: 14px;'>" . htmlspecialchars($hash) . "</p>";

echo "<hr>";
echo "<h2>📋 Instrucciones para cambiar la contraseña en phpMyAdmin:</h2>";
echo "<ol style='line-height: 1.8;'>";
echo "<li>Ve a phpMyAdmin → Base de datos <code>u337903245_thellsol</code> → Tabla <code>admin_users</code></li>";
echo "<li>Haz clic en <strong>Editar</strong> en la fila del usuario que quieres modificar</li>";
echo "<li>En el campo <code>password_hash</code>, pega el hash generado arriba</li>";
echo "<li>Haz clic en <strong>Continuar</strong> o <strong>Guardar</strong></li>";
echo "<li>¡Listo! La contraseña estará cambiada inmediatamente</li>";
echo "</ol>";

echo "<hr>";
echo "<h2>🔍 Verificar contraseña actual:</h2>";
echo "<p>Si quieres verificar qué contraseña corresponde a un hash existente, necesitas probar manualmente.</p>";
echo "<p>El hash que viste en phpMyAdmin es: <code style='background: #fff3cd; padding: 5px; border-radius: 3px;'>\$2y\$10\$d/XpFlRzKTFeWFp0sFQtbOTcyelHuBwFqqTzHzR1u0OPTr9E6QnKe</code></p>";
echo "<p><strong>No puedo deshashear esto</strong> - es imposible por diseño de seguridad.</p>";

echo "<hr>";
echo "<h2>💡 Recomendación:</h2>";
echo "<p>Si no recuerdas la contraseña actual, simplemente:</p>";
echo "<ol>";
echo "<li>Cambia el hash en phpMyAdmin usando el generador de arriba</li>";
echo "<li>Usa la nueva contraseña que pusiste en <code>\$nuevaPassword</code></li>";
echo "<li>Esa será tu nueva contraseña para iniciar sesión</li>";
echo "</ol>";
?>

