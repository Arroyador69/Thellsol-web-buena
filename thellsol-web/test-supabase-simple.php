<?php
// Test simple para diagnosticar problemas de conexión con Supabase
// Archivo: test-supabase-simple.php

echo "<h1>🔧 Test Simple de Conexión Supabase</h1>";

// Configuración CORRECTA de Supabase
$supabaseUrl = 'https://hhfkutuhvsjfbrwozvdq.supabase.co';
$supabaseKey = 'sb_publishable_2uC8yz0GQ17I58xtqtH6gw_5QUAc9KK';

echo "<h2>📋 Información de Configuración</h2>";
echo "<p><strong>URL Supabase:</strong> $supabaseUrl</p>";
echo "<p><strong>API Key:</strong> " . substr($supabaseKey, 0, 20) . "...</p>";

// Test 1: Verificar si cURL está disponible
echo "<h2>🔍 Test 1: Verificar cURL</h2>";
if (function_exists('curl_init')) {
    echo "✅ cURL está disponible<br>";
} else {
    echo "❌ cURL NO está disponible<br>";
    exit;
}

// Test 2: Verificar conectividad básica
echo "<h2>🔍 Test 2: Conectividad Básica</h2>";
$testUrl = $supabaseUrl . '/rest/v1/';
echo "<p>Probando conexión a: $testUrl</p>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $testUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'apikey: ' . $supabaseKey,
    'Authorization: Bearer ' . $supabaseKey
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "<p><strong>Código HTTP:</strong> $httpCode</p>";
echo "<p><strong>Error cURL:</strong> " . ($error ? $error : 'Ninguno') . "</p>";
echo "<p><strong>Tiempo de respuesta:</strong> " . $info['total_time'] . " segundos</p>";

if ($error) {
    echo "<p style='color: red;'>❌ Error de conexión: $error</p>";
} else {
    echo "<p style='color: green;'>✅ Conexión básica exitosa</p>";
}

// Test 3: Verificar tabla Property
echo "<h2>🔍 Test 3: Verificar Tabla Property</h2>";
$propertyUrl = $supabaseUrl . '/rest/v1/Property?select=*&limit=1';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $propertyUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'apikey: ' . $supabaseKey,
    'Authorization: Bearer ' . $supabaseKey
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "<p><strong>URL de prueba:</strong> $propertyUrl</p>";
echo "<p><strong>Código HTTP:</strong> $httpCode</p>";

if ($httpCode === 200) {
    echo "<p style='color: green;'>✅ Tabla Property existe y es accesible</p>";
    $data = json_decode($response, true);
    if (is_array($data)) {
        echo "<p><strong>Propiedades encontradas:</strong> " . count($data) . "</p>";
        if (!empty($data)) {
            echo "<p><strong>Primera propiedad:</strong></p>";
            echo "<pre>" . print_r($data[0], true) . "</pre>";
        }
    }
} elseif ($httpCode === 404) {
    echo "<p style='color: red;'>❌ Tabla Property NO existe (Error 404)</p>";
} elseif ($httpCode === 401) {
    echo "<p style='color: red;'>❌ Error de autenticación (Error 401) - Verificar API Key</p>";
} elseif ($httpCode === 403) {
    echo "<p style='color: red;'>❌ Error de permisos (Error 403) - Verificar políticas de la tabla</p>";
} else {
    echo "<p style='color: orange;'>⚠️ Código HTTP inesperado: $httpCode</p>";
    echo "<p><strong>Respuesta:</strong> $response</p>";
}

// Test 4: Verificar estructura de la tabla
echo "<h2>🔍 Test 4: Verificar Estructura de la Tabla</h2>";
$schemaUrl = $supabaseUrl . '/rest/v1/Property?select=*&limit=0';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $schemaUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'apikey: ' . $supabaseKey,
    'Authorization: Bearer ' . $supabaseKey
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    echo "<p style='color: green;'>✅ Estructura de tabla accesible</p>";
} else {
    echo "<p style='color: red;'>❌ No se puede acceder a la estructura de la tabla</p>";
}

// Test 5: Crear propiedad de prueba
echo "<h2>🔍 Test 5: Crear Propiedad de Prueba</h2>";
$testProperty = [
    'title' => 'Propiedad de Test - ' . date('Y-m-d H:i:s'),
    'description' => 'Propiedad de prueba para verificar conexión',
    'price' => 250000,
    'location' => 'fuengirola',
    'type' => 'villa',
    'bedrooms' => 3,
    'bathrooms' => 2,
    'area' => 150,
    'status' => 'for-sale'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $supabaseUrl . '/rest/v1/Property');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testProperty));
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'apikey: ' . $supabaseKey,
    'Authorization: Bearer ' . $supabaseKey
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "<p><strong>Código HTTP:</strong> $httpCode</p>";
echo "<p><strong>Respuesta:</strong> $response</p>";

if ($httpCode === 201) {
    echo "<p style='color: green;'>✅ Propiedad de prueba creada exitosamente</p>";
} else {
    echo "<p style='color: red;'>❌ Error al crear propiedad de prueba</p>";
}

echo "<h2>📋 Resumen</h2>";
echo "<p>Si ves errores en los tests anteriores, necesitamos:</p>";
echo "<ol>";
echo "<li>Verificar la URL de Supabase en tu panel</li>";
echo "<li>Verificar que la tabla 'Property' existe</li>";
echo "<li>Verificar las políticas de acceso de la tabla</li>";
echo "<li>Verificar que la API Key es correcta</li>";
echo "</ol>";

echo "<p><a href='test-supabase-connection.php'>← Volver al test principal</a></p>";
?>
