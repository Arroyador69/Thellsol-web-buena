<?php
header('Content-Type: application/json');
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

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Obtener propiedades
        $stmt = $pdo->query("SELECT * FROM properties ORDER BY id DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'POST':
        // Crear nueva propiedad
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Subir imagen si existe
        $image_path = null;
        if (isset($_FILES['image'])) {
            $image_path = uploadImage($_FILES['image']);
        }
        
        $stmt = $pdo->prepare("INSERT INTO properties (title, price, type, location, bedrooms, bathrooms, area, description, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['title'],
            $data['price'],
            $data['type'],
            $data['location'],
            $data['bedrooms'],
            $data['bathrooms'],
            $data['area'],
            $data['description'],
            $image_path
        ]);
        
        $property_id = $pdo->lastInsertId();
        
        // Guardar características
        if (isset($data['features'])) {
            $stmt = $pdo->prepare("INSERT INTO features (property_id, feature_name) VALUES (?, ?)");
            foreach ($data['features'] as $feature) {
                $stmt->execute([$property_id, $feature]);
            }
        }
        
        echo json_encode(['success' => true, 'id' => $property_id]);
        break;

    case 'PUT':
        // Actualizar propiedad
        $data = json_decode(file_get_contents('php://input'), true);
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
        if (isset($_FILES['image'])) {
            $image_path = uploadImage($_FILES['image']);
            if ($image_path) {
                $stmt = $pdo->prepare("UPDATE properties SET image_url = ? WHERE id = ?");
                $stmt->execute([$image_path, $id]);
            }
        }
        
        // Actualizar características
        $stmt = $pdo->prepare("DELETE FROM features WHERE property_id = ?");
        $stmt->execute([$id]);
        
        if (isset($data['features'])) {
            $stmt = $pdo->prepare("INSERT INTO features (property_id, feature_name) VALUES (?, ?)");
            foreach ($data['features'] as $feature) {
                $stmt->execute([$id, $feature]);
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
}
?> 