<?php
// Configuración
$destino = 'andre@thellsol.com';
$asunto = 'Nuevo mensaje desde la encuesta de Vender';

// Recoger datos
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

// Validación básica
if ($nombre && $telefono && $email) {
    $contenido = "Nombre: $nombre\n";
    $contenido .= "Teléfono: $telefono\n";
    $contenido .= "Email: $email\n";
    $contenido .= "Mensaje: $mensaje\n";
    $headers = "From: $email\r\nReply-To: $email\r\n";
    if (mail($destino, $asunto, $contenido, $headers)) {
        echo '<div style="max-width:500px;margin:48px auto 32px auto;background:#fff;border-radius:12px;box-shadow:0 2px 8px #0001;padding:32px 24px 24px 24px;font-family:sans-serif;text-align:center;">¡Gracias! Tu mensaje ha sido enviado correctamente.<br><a href="vender.html" style="color:#181e29;text-decoration:underline;">Volver</a></div>';
    } else {
        echo '<div style="max-width:500px;margin:48px auto 32px auto;background:#fff;border-radius:12px;box-shadow:0 2px 8px #0001;padding:32px 24px 24px 24px;font-family:sans-serif;text-align:center;color:#b00;">Error al enviar el mensaje. Inténtalo de nuevo.<br><a href="vender.html" style="color:#181e29;text-decoration:underline;">Volver</a></div>';
    }
} else {
    echo '<div style="max-width:500px;margin:48px auto 32px auto;background:#fff;border-radius:12px;box-shadow:0 2px 8px #0001;padding:32px 24px 24px 24px;font-family:sans-serif;text-align:center;color:#b00;">Por favor, rellena todos los campos obligatorios.<br><a href="vender.html" style="color:#181e29;text-decoration:underline;">Volver</a></div>';
} 