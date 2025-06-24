<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config.php';

// Función para subir imágenes
function uploadImage($file) {
    $target_dir = "../uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return "uploads/" . $new_filename;
    }
    return false;
}

// Función para obtener características de una propiedad
function getPropertyFeatures($pdo, $property_id) {
    $stmt = $pdo->prepare("SELECT feature_name FROM features WHERE property_id = ?");
    $stmt->execute([$property_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Obtener una propiedad específica
            $stmt = $pdo->prepare("SELECT * FROM properties WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $property = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($property) {
                $property['features'] = getPropertyFeatures($pdo, $property['id']);
                echo json_encode($property);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Propiedad no encontrada']);
            }
        } else {
            // Obtener todas las propiedades
            $stmt = $pdo->query("SELECT * FROM properties ORDER BY id DESC");
            $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Agregar características a cada propiedad
            foreach ($properties as &$property) {
                $property['features'] = getPropertyFeatures($pdo, $property['id']);
            }
            
            echo json_encode($properties);
        }
        break;

    case 'POST':
        // Crear nueva propiedad
        $data = $_POST;
        
        // Subir imagen si existe
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_path = uploadImage($_FILES['image']);
        }
        
        $stmt = $pdo->prepare("INSERT INTO properties (title, price, type, location, bedrooms, bathrooms, area, description, image_url, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['title'],
            $data['price'],
            $data['type'],
            $data['location'],
            $data['bedrooms'],
            $data['bathrooms'],
            $data['area'],
            $data['description'],
            $image_path,
            'active'
        ]);
        
        $property_id = $pdo->lastInsertId();
        
        // Guardar características
        if (isset($data['features']) && is_array($data['features'])) {
            $stmt = $pdo->prepare("INSERT INTO features (property_id, feature_name) VALUES (?, ?)");
            foreach ($data['features'] as $feature) {
                $stmt->execute([$property_id, $feature]);
            }
        }
        
        // Guardar imágenes adicionales (galería)
        if (isset($_FILES['gallery'])) {
            foreach ($_FILES['gallery']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['gallery']['error'][$key] === UPLOAD_ERR_OK) {
                    $file = [
                        'name' => $_FILES['gallery']['name'][$key],
                        'tmp_name' => $tmp_name
                    ];
                    $gallery_path = uploadImage($file);
                    if ($gallery_path) {
                        $stmt = $pdo->prepare("INSERT INTO property_images (property_id, image_path) VALUES (?, ?)");
                        $stmt->execute([$property_id, $gallery_path]);
                    }
                }
            }
        }
        
        echo json_encode(['success' => true, 'id' => $property_id]);
        break;

    case 'PUT':
        // Actualizar propiedad
        parse_str(file_get_contents("php://input"), $data);
        
        $id = $data['id'];
        
        $stmt = $pdo->prepare("UPDATE properties SET title = ?, price = ?, type = ?, location = ?, bedrooms = ?, bathrooms = ?, area = ?, description = ? WHERE id = ?");
        $stmt->execute([
            $data['title'],
            $data['price'],
            $data['type'],
            $data['location'],
            $data['bedrooms'],
            $data['bathrooms'],
            $data['area'],
            $data['description'],
            $id
        ]);
        
        // Actualizar imagen si se proporciona una nueva
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_path = uploadImage($_FILES['image']);
            if ($image_path) {
                $stmt = $pdo->prepare("UPDATE properties SET image_url = ? WHERE id = ?");
                $stmt->execute([$image_path, $id]);
            }
        }
        
        // Actualizar características
        $stmt = $pdo->prepare("DELETE FROM features WHERE property_id = ?");
        $stmt->execute([$id]);
        
        if (isset($data['features']) && is_array($data['features'])) {
            $stmt = $pdo->prepare("INSERT INTO features (property_id, feature_name) VALUES (?, ?)");
            foreach ($data['features'] as $feature) {
                $stmt->execute([$id, $feature]);
            }
        }
        
        // Guardar imágenes adicionales (galería)
        if (isset($_FILES['gallery'])) {
            foreach ($_FILES['gallery']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['gallery']['error'][$key] === UPLOAD_ERR_OK) {
                    $file = [
                        'name' => $_FILES['gallery']['name'][$key],
                        'tmp_name' => $tmp_name
                    ];
                    $gallery_path = uploadImage($file);
                    if ($gallery_path) {
                        $stmt = $pdo->prepare("INSERT INTO property_images (property_id, image_path) VALUES (?, ?)");
                        $stmt->execute([$id, $gallery_path]);
                    }
                }
            }
        }
        
        echo json_encode(['success' => true]);
        break;

    case 'DELETE':
        // Eliminar propiedad
        $id = $_GET['id'];
        
        // Eliminar características primero
        $stmt = $pdo->prepare("DELETE FROM features WHERE property_id = ?");
        $stmt->execute([$id]);
        
        // Eliminar propiedad
        $stmt = $pdo->prepare("DELETE FROM properties WHERE id = ?");
        $stmt->execute([$id]);
        
        echo json_encode(['success' => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?> 