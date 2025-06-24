<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config.php';

// Función para obtener información de archivos
function getFileInfo($filepath) {
    if (file_exists($filepath)) {
        return [
            'size' => filesize($filepath),
            'modified' => filemtime($filepath)
        ];
    }
    return null;
}

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Obtener lista de imágenes
        $upload_dir = "../uploads/";
        $images = [];
        
        if (is_dir($upload_dir)) {
            $files = scandir($upload_dir);
            
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && is_file($upload_dir . $file)) {
                    $filepath = $upload_dir . $file;
                    $fileInfo = getFileInfo($filepath);
                    
                    if ($fileInfo) {
                        $images[] = [
                            'id' => count($images) + 1, // ID simple para el ejemplo
                            'name' => $file,
                            'path' => 'uploads/' . $file,
                            'size' => $fileInfo['size'],
                            'modified' => $fileInfo['modified']
                        ];
                    }
                }
            }
        }
        
        // Ordenar por fecha de modificación (más recientes primero)
        usort($images, function($a, $b) {
            return $b['modified'] - $a['modified'];
        });
        
        echo json_encode($images);
        break;

    case 'DELETE':
        // Eliminar imagen
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // En un sistema real, tendrías una tabla de imágenes en la BD
            // Por ahora, eliminamos por nombre de archivo
            $upload_dir = "../uploads/";
            $files = scandir($upload_dir);
            $fileIndex = 0;
            
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && is_file($upload_dir . $file)) {
                    $fileIndex++;
                    if ($fileIndex == $id) {
                        $filepath = $upload_dir . $file;
                        if (unlink($filepath)) {
                            echo json_encode(['success' => true]);
                        } else {
                            http_response_code(500);
                            echo json_encode(['error' => 'Error al eliminar el archivo']);
                        }
                        exit;
                    }
                }
            }
            
            http_response_code(404);
            echo json_encode(['error' => 'Imagen no encontrada']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID de imagen requerido']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?> 