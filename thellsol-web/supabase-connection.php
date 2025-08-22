<?php
// Conexión a Supabase desde PHP
// Archivo: supabase-connection.php

class SupabaseConnection {
    private $supabaseUrl;
    private $supabaseKey;
    
    public function __construct() {
        // Configuración de Supabase
        $this->supabaseUrl = 'https://spdwjdrlemselkqbxau.supabase.co';
        $this->supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InNwZHdqZHJsZW1zZWxrcWJ4YXVlIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTU2MTU0MzcsImV4cCI6MjA3MTE5MTQzN30.BzX55tzKeSGEL9D7wgJG4M-DCcmQ3K4fZjcHR-LMnAs';
    }
    
    // Función para hacer peticiones a Supabase
    public function makeRequest($endpoint, $method = 'GET', $data = null) {
        $url = $this->supabaseUrl . '/rest/v1/' . $endpoint;
        
        $headers = [
            'Content-Type: application/json',
            'apikey: ' . $this->supabaseKey,
            'Authorization: Bearer ' . $this->supabaseKey
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        
        if ($data && ($method === 'POST' || $method === 'PUT' || $method === 'PATCH')) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return [
            'status' => $httpCode,
            'data' => json_decode($response, true)
        ];
    }
    
    // Obtener todas las propiedades
    public function getProperties() {
        return $this->makeRequest('Property?select=*&order=createdAt.desc');
    }
    
    // Crear nueva propiedad
    public function createProperty($propertyData) {
        return $this->makeRequest('Property', 'POST', $propertyData);
    }
    
    // Eliminar propiedad
    public function deleteProperty($id) {
        return $this->makeRequest('Property?id=eq.' . $id, 'DELETE');
    }
    
    // Actualizar propiedad
    public function updateProperty($id, $propertyData) {
        return $this->makeRequest('Property?id=eq.' . $id, 'PATCH', $propertyData);
    }
}

// Función helper para mostrar propiedades en HTML
function displayProperties($properties) {
    if (empty($properties)) {
        echo '<p>No hay propiedades disponibles.</p>';
        return;
    }
    
    foreach ($properties as $property) {
        echo '<div class="property-card">';
        echo '<h3>' . htmlspecialchars($property['title']) . '</h3>';
        echo '<p class="price">' . number_format($property['price']) . '€</p>';
        echo '<p class="location">' . htmlspecialchars($property['location']) . ' - ' . htmlspecialchars($property['type']) . '</p>';
        if ($property['bedrooms']) echo '<p>Habitaciones: ' . $property['bedrooms'] . '</p>';
        if ($property['bathrooms']) echo '<p>Baños: ' . $property['bathrooms'] . '</p>';
        if ($property['area']) echo '<p>Superficie: ' . $property['area'] . 'm²</p>';
        echo '<p>Estado: ' . htmlspecialchars($property['status']) . '</p>';
        echo '</div>';
    }
}

// Función para manejar formularios de propiedades
function handlePropertyForm() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        $supabase = new SupabaseConnection();
        
        switch ($_POST['action']) {
            case 'create':
                $propertyData = [
                    'title' => $_POST['title'],
                    'description' => $_POST['description'] ?? '',
                    'price' => floatval($_POST['price']),
                    'location' => $_POST['location'],
                    'type' => $_POST['type'],
                    'bedrooms' => !empty($_POST['bedrooms']) ? intval($_POST['bedrooms']) : null,
                    'bathrooms' => !empty($_POST['bathrooms']) ? intval($_POST['bathrooms']) : null,
                    'area' => !empty($_POST['area']) ? intval($_POST['area']) : null,
                    'status' => $_POST['status'] ?? 'for-sale'
                ];
                
                $result = $supabase->createProperty($propertyData);
                if ($result['status'] === 201) {
                    return ['success' => true, 'message' => 'Propiedad creada correctamente'];
                } else {
                    return ['success' => false, 'message' => 'Error al crear la propiedad'];
                }
                break;
                
            case 'delete':
                if (isset($_POST['id'])) {
                    $result = $supabase->deleteProperty($_POST['id']);
                    if ($result['status'] === 204) {
                        return ['success' => true, 'message' => 'Propiedad eliminada correctamente'];
                    } else {
                        return ['success' => false, 'message' => 'Error al eliminar la propiedad'];
                    }
                }
                break;
        }
    }
    return null;
}
?>
