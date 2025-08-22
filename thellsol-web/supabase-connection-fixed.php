<?php
// Conexión mejorada a Supabase desde PHP
// Archivo: supabase-connection-fixed.php

class SupabaseConnectionFixed {
    private $supabaseUrl;
    private $supabaseKey;
    
    public function __construct() {
        // Configuración de Supabase
        $this->supabaseUrl = 'https://spdwjdrlemselkqbxau.supabase.co';
        $this->supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InNwZHdqZHJsZW1zZWxrcWJ4YXVlIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTU2MTU0MzcsImV4cCI6MjA3MTE5MTQzN30.BzX55tzKeSGEL9D7wgJG4M-DCcmQ3K4fZjcHR-LMnAs';
    }
    
    // Función para hacer peticiones a Supabase usando file_get_contents
    public function makeRequest($endpoint, $method = 'GET', $data = null) {
        $url = $this->supabaseUrl . '/rest/v1/' . $endpoint;
        
        $context = stream_context_create([
            'http' => [
                'method' => $method,
                'header' => [
                    'Content-Type: application/json',
                    'apikey: ' . $this->supabaseKey,
                    'Authorization: Bearer ' . $this->supabaseKey,
                    'User-Agent: ThellSol-Web/1.0'
                ],
                'timeout' => 30,
                'ignore_errors' => true
            ]
        ]);
        
        if ($data && ($method === 'POST' || $method === 'PUT' || $method === 'PATCH')) {
            $context = stream_context_create([
                'http' => [
                    'method' => $method,
                    'header' => [
                        'Content-Type: application/json',
                        'apikey: ' . $this->supabaseKey,
                        'Authorization: Bearer ' . $this->supabaseKey,
                        'User-Agent: ThellSol-Web/1.0'
                    ],
                    'content' => json_encode($data),
                    'timeout' => 30,
                    'ignore_errors' => true
                ]
            ]);
        }
        
        $response = file_get_contents($url, false, $context);
        
        if ($response === false) {
            return [
                'status' => 0,
                'data' => null,
                'error' => 'No se pudo conectar a Supabase'
            ];
        }
        
        // Obtener el código de estado HTTP
        $httpResponse = $http_response_header ?? [];
        $statusLine = $httpResponse[0] ?? '';
        preg_match('/HTTP\/\d\.\d\s+(\d+)/', $statusLine, $matches);
        $httpCode = isset($matches[1]) ? intval($matches[1]) : 0;
        
        return [
            'status' => $httpCode,
            'data' => json_decode($response, true),
            'raw_response' => $response
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
function displayPropertiesFixed($properties) {
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
?>
