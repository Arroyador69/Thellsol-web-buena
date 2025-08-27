<?php
// Script para manejar la subida de imágenes
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit();
}

// Crear directorio de imágenes si no existe
$uploadDir = 'images/properties/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$uploadedImages = [];
$errors = [];

if (isset($_FILES['imageFiles'])) {
    $files = $_FILES['imageFiles'];
    $totalFiles = count($files['name']);
    
    for ($i = 0; $i < $totalFiles; $i++) {
        if ($files['error'][$i] === UPLOAD_ERR_OK) {
            $fileName = $files['name'][$i];
            $tmpName = $files['tmp_name'][$i];
            $fileSize = $files['size'][$i];
            $fileType = $files['type'][$i];
            
            // Validar tipo de archivo
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($fileType, $allowedTypes)) {
                $errors[] = "Tipo de archivo no permitido: $fileName";
                continue;
            }
            
            // Validar tamaño (máximo 5MB)
            if ($fileSize > 5 * 1024 * 1024) {
                $errors[] = "Archivo muy grande: $fileName (máximo 5MB)";
                continue;
            }
            
            // Generar nombre único
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $uniqueName = uniqid('prop_') . '.' . $extension;
            $uploadPath = $uploadDir . $uniqueName;
            
            if (move_uploaded_file($tmpName, $uploadPath)) {
                $uploadedImages[] = [
                    'original_name' => $fileName,
                    'file_name' => $uniqueName,
                    'url' => $uploadPath
                ];
            } else {
                $errors[] = "Error al subir: $fileName";
            }
        } else {
            $errors[] = "Error en archivo: " . $files['name'][$i];
        }
    }
}

echo json_encode([
    'success' => empty($errors),
    'uploaded_images' => $uploadedImages,
    'errors' => $errors
]);
?>
