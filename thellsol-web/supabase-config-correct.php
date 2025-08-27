<?php
// Configuración CORRECTA de Supabase
// Archivo: supabase-config-correct.php

// NUEVA CONFIGURACIÓN CORRECTA
$supabaseUrl = 'https://hhfkutuhvsjfbrwozvdq.supabase.co';
$supabaseKey = 'sb_publishable_2uC8yz0GQ17I58xtqtH6gw_5QUAc9KK';

// Función para hacer peticiones a Supabase usando cURL
function makeSupabaseRequest($endpoint, $method = 'GET', $data = null) {
    global $supabaseUrl, $supabaseKey;
    
    $url = $supabaseUrl . '/rest/v1/' . $endpoint;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'apikey: ' . $supabaseKey,
        'Authorization: Bearer ' . $supabaseKey
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    if ($data && ($method === 'POST' || $method === 'PUT' || $method === 'PATCH')) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return [
            'success' => false,
            'error' => 'cURL Error: ' . $error
        ];
    }
    
    return [
        'success' => $httpCode === 200 || $httpCode === 201,
        'status' => $httpCode,
        'data' => json_decode($response, true),
        'raw_response' => $response
    ];
}

// Test de conexión
echo "<h1>🔧 Test de Configuración CORRECTA</h1>";
echo "<p><strong>URL:</strong> $supabaseUrl</p>";
echo "<p><strong>Key:</strong> " . substr($supabaseKey, 0, 20) . "...</p>";

// Probar conexión
$result = makeSupabaseRequest('Property?select=*&limit=1');

if ($result['success']) {
    echo "<p style='color: green;'>✅ Conexión exitosa con Supabase</p>";
    echo "<p><strong>Código HTTP:</strong> " . $result['status'] . "</p>";
    
    if (is_array($result['data'])) {
        echo "<p><strong>Propiedades encontradas:</strong> " . count($result['data']) . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Error de conexión</p>";
    echo "<p><strong>Error:</strong> " . $result['error'] . "</p>";
    echo "<p><strong>Código HTTP:</strong> " . $result['status'] . "</p>";
}

echo "<h2>📋 Instrucciones para actualizar archivos:</h2>";
echo "<p>Reemplaza en todos los archivos PHP:</p>";
echo "<pre>";
echo "// ANTIGUO (INCORRECTO):\n";
echo '$supabaseUrl = \'https://spdwjdrlemselkqbxau.supabase.co\';\n';
echo '$supabaseKey = \'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...\';\n\n';
echo "// NUEVO (CORRECTO):\n";
echo '$supabaseUrl = \'https://hhfkutuhvsjfbrwozvdq.supabase.co\';\n';
echo '$supabaseKey = \'sb_publishable_2uC8yz0GQ17I58xtqtH6gw_5QUAc9KK\';\n';
echo "</pre>";
?>
