<?php
// Test completo de conexión y propiedades
// Archivo: test-connection-complete.php

echo "<h1>🔧 Test Completo de Conexión y Propiedades</h1>";

// Configuración CORRECTA
$supabaseUrl = 'https://hhfkutuhvsjfbrwozvdq.supabase.co';
$supabaseKey = 'sb_publishable_2uC8yz0GQ17I58xtqtH6gw_5QUAc9KK';

echo "<h2>📋 Configuración Actual:</h2>";
echo "<p><strong>URL:</strong> $supabaseUrl</p>";
echo "<p><strong>Key:</strong> " . substr($supabaseKey, 0, 20) . "...</p>";

// Función para hacer peticiones
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

// Test 1: Conexión básica
echo "<h2>🧪 Test 1: Conexión Básica</h2>";
$result = makeSupabaseRequest('Property?select=*&limit=1');

if ($result['success']) {
    echo "<p style='color: green;'>✅ Conexión exitosa con Supabase</p>";
    echo "<p><strong>Código HTTP:</strong> " . $result['status'] . "</p>";
} else {
    echo "<p style='color: red;'>❌ Error de conexión</p>";
    echo "<p><strong>Error:</strong> " . $result['error'] . "</p>";
    echo "<p><strong>Código HTTP:</strong> " . $result['status'] . "</p>";
}

// Test 2: Obtener todas las propiedades
echo "<h2>🏠 Test 2: Propiedades en la Base de Datos</h2>";
$result = makeSupabaseRequest('Property?select=*&order=createdAt.desc');

if ($result['success']) {
    $properties = $result['data'] ?? [];
    echo "<p style='color: green;'>✅ Propiedades obtenidas correctamente</p>";
    echo "<p><strong>Total de propiedades:</strong> " . count($properties) . "</p>";
    
    if (count($properties) > 0) {
        echo "<h3>📋 Lista de Propiedades:</h3>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'>";
        echo "<th>ID</th><th>Título</th><th>Precio</th><th>Ubicación</th><th>Tipo</th><th>Estado</th>";
        echo "</tr>";
        
        foreach ($properties as $property) {
            echo "<tr>";
            echo "<td>" . ($property['id'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($property['title'] ?? 'N/A') . "</td>";
            echo "<td>" . number_format($property['price'] ?? 0) . "€</td>";
            echo "<td>" . htmlspecialchars($property['location'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($property['type'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($property['status'] ?? 'N/A') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: orange;'>⚠️ No hay propiedades en la base de datos</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Error al obtener propiedades</p>";
    echo "<p><strong>Error:</strong> " . $result['error'] . "</p>";
}

// Test 3: Verificar API del dashboard
echo "<h2>🔗 Test 3: API del Dashboard</h2>";
$apiUrl = 'dashboard-api.php';
try {
    $response = file_get_contents($apiUrl);
    if ($response !== false) {
        $data = json_decode($response, true);
        if ($data && $data['success']) {
            echo "<p style='color: green;'>✅ API del dashboard funciona</p>";
            echo "<p><strong>Propiedades en API:</strong> " . count($data['properties'] ?? []) . "</p>";
        } else {
            echo "<p style='color: red;'>❌ API del dashboard devuelve error</p>";
            echo "<p><strong>Error:</strong> " . ($data['error'] ?? 'Error desconocido') . "</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ No se puede acceder a la API del dashboard</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error al acceder a la API: " . $e->getMessage() . "</p>";
}

echo "<h2>🔧 Solución Recomendada:</h2>";
echo "<p>El problema principal es que <strong>dashboard-api.php</strong> usa la configuración ANTIGUA de Supabase.</p>";
echo "<p>Necesitas actualizar la configuración en ese archivo.</p>";
?>
