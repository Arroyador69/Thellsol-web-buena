<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Verificar que se haya subido un archivo
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'No se ha subido ningún archivo o hay un error']);
    exit;
}

$file = $_FILES['image'];

// Verificar el tipo de archivo
$allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
if (!in_array($file['type'], $allowed_types)) {
    http_response_code(400);
    echo json_encode(['error' => 'Tipo de archivo no permitido. Solo se permiten imágenes.']);
    exit;
}

// Verificar el tamaño del archivo (5MB máximo)
if ($file['size'] > MAX_FILE_SIZE) {
    http_response_code(400);
    echo json_encode(['error' => 'El archivo es demasiado grande. Máximo 5MB.']);
    exit;
}

// Crear directorio de uploads si no existe
$upload_dir = "../uploads/";
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Generar nombre único para el archivo
$file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$new_filename = uniqid() . '_' . time() . '.' . $file_extension;
$target_file = $upload_dir . $new_filename;

// Mover el archivo subido
if (move_uploaded_file($file['tmp_name'], $target_file)) {
    echo json_encode([
        'success' => true,
        'filename' => $new_filename,
        'path' => 'uploads/' . $new_filename,
        'size' => $file['size']
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar el archivo']);
}
?> 