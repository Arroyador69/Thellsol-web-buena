<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST['nombre']) ? strip_tags($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? strip_tags($_POST['email']) : '';
    $mensaje = isset($_POST['mensaje']) ? strip_tags($_POST['mensaje']) : '';
    
    $to = "andre@thellsol.com";
    $subject = "Nuevo mensaje desde el formulario de Vender";
    $body = "Nombre: $nombre\nEmail: $email\nMensaje: $mensaje";
    $headers = "From: $email\r\nReply-To: $email";
    
    // Enviar el correo
    mail($to, $subject, $body, $headers);
    // Redirigir a página de gracias
    header("Location: gracias.html");
    exit();
} else {
    // Si se accede directamente, redirigir al inicio
    header("Location: index.html");
    exit();
} 