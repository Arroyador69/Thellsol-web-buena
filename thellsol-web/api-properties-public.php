<?php
// API Pública para obtener propiedades del dashboard
// Archivo: api-properties-public.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Configuración de Supabase (misma que el dashboard)
$supabaseUrl = 'https://spdwjdrlemselkqbxau.supabase.co';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InNwZHdqZHJsZW1zZWxrcWJ4YXVlIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTU2MTU0MzcsImV4cCI6MjA3MTE5MTQzN30.BzX55tzKeSGEL9D7wgJG4M-DCcmQ3K4fZjcHR-LMnAs';

// Función para hacer peticiones a Supabase
function makeSupabaseRequest($endpoint, $method = 'GET', $data = null) {
    global $supabaseUrl, $supabaseKey;
    
    $url = $supabaseUrl . '/rest/v1/' . $endpoint;
    
    $context = stream_context_create([
        'http' => [
            'method' => $method,
            'header' => [
                'Content-Type: application/json',
                'apikey: ' . $supabaseKey,
                'Authorization: Bearer ' . $supabaseKey,
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
                    'apikey: ' . $supabaseKey,
                    'Authorization: Bearer ' . $supabaseKey,
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
            'success' => false,
            'error' => 'No se pudo conectar a Supabase'
        ];
    }
    
    // Obtener el código de estado HTTP
    $httpResponse = $http_response_header ?? [];
    $statusLine = $httpResponse[0] ?? '';
    preg_match('/HTTP\/\d\.\d\s+(\d+)/', $statusLine, $matches);
    $httpCode = isset($matches[1]) ? intval($matches[1]) : 0;
    
    return [
        'success' => $httpCode === 200,
        'status' => $httpCode,
        'data' => json_decode($response, true),
        'raw_response' => $response
    ];
}

// Manejar la petición
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($method === 'GET') {
    // Obtener todas las propiedades
    $result = makeSupabaseRequest('Property?select=*&order=createdAt.desc');
    
    if ($result['success']) {
        echo json_encode([
            'success' => true,
            'properties' => $result['data'],
            'count' => count($result['data'])
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Error al obtener propiedades',
            'details' => $result['error'] ?? 'Error desconocido'
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Método no permitido'
    ]);
}
?>
