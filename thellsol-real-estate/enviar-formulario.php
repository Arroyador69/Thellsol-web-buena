<?php
// 1. Verifica que se ha enviado por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2. Recoge los datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $email = $_POST['email'] ?? '';
    $mensaje = $_POST['mensaje'] ?? 'Sin mensaje';

    // 3. Configura el correo de destino
    $destino = "andre@thellsol.com"; // Email de ThellSol
    $asunto = "Nueva solicitud desde el formulario de venta";
    $contenido = "Nombre: $nombre\n";
    $contenido .= "Teléfono: $telefono\n";
    $contenido .= "Email: $email\n";
    $contenido .= "Mensaje: $mensaje\n";

    // 4. Encabezados del correo
    $headers = "From: no-reply@thellsol.com\r\n";

    // 5. Envía el correo
    if (mail($destino, $asunto, $contenido, $headers)) {
        // 6. Redirige a una página de gracias
        header("Location: gracias.html");
        exit;
    } else {
        echo "Error al enviar el mensaje. Intenta más tarde.";
    }
} else {
    echo "Acceso no permitido.";
}
?> 