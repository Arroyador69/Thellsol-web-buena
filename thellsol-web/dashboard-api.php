<?php
// API LOCAL para el sistema de propiedades
// Archivo: dashboard-api.php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$propertiesFile = "properties.json";

// Funciones para manejar el archivo JSON local
function getProperties() {
    global $propertiesFile;
    if (!file_exists($propertiesFile)) {
        return [];
    }
    $content = file_get_contents($propertiesFile);
    return json_decode($content, true) ?: [];
}

function saveProperties($properties) {
    global $propertiesFile;
    return file_put_contents($propertiesFile, json_encode($properties, JSON_PRETTY_PRINT));
}

function getNextId($properties) {
    if (empty($properties)) {
        return 1;
    }
    $maxId = 0;
    foreach ($properties as $property) {
        if (isset($property['id']) && is_numeric($property['id']) && $property['id'] > $maxId) {
            $maxId = $property['id'];
        }
    }
    return $maxId + 1;
}

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "OPTIONS") {
    http_response_code(200);
    exit();
}

if ($method === "GET") {
    $properties = getProperties();
    echo json_encode([
        "success" => true,
        "properties" => $properties,
        "count" => count($properties)
    ]);
} elseif ($method === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    
    if (!$data) {
        http_response_code(400);
        echo json_encode(["success" => false, "error" => "Datos inválidos"]);
        exit();
    }
    
    $properties = getProperties();
    $newProperty = [
        "id" => getNextId($properties),
        "title" => $data["title"] ?? "",
        "price" => $data["price"] ?? 0,
        "location" => $data["location"] ?? "",
        "type" => $data["type"] ?? "",
        "bedrooms" => $data["bedrooms"] ?? 0,
        "bathrooms" => $data["bathrooms"] ?? 0,
        "surface" => $data["surface"] ?? 0,
        "description" => $data["description"] ?? "",
        "images" => $data["images"] ?? [],
        "createdAt" => date("Y-m-d H:i:s"),
        "status" => "active"
    ];
    
    $properties[] = $newProperty;
    
    if (saveProperties($properties)) {
        echo json_encode(["success" => true, "property" => $newProperty]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => "Error al guardar la propiedad"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
}
?>
