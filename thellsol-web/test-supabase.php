<?php
require_once 'supabase-connection.php';

echo "<h1>Test de Conexión Supabase - Diagnóstico Completo</h1>";

// Verificar configuración
echo "<h2>1. Configuración:</h2>";
$supabase = new SupabaseConnection();

// Usar reflexión para acceder a propiedades privadas
$reflection = new ReflectionClass($supabase);
$urlProperty = $reflection->getProperty('supabaseUrl');
$keyProperty = $reflection->getProperty('supabaseKey');
$urlProperty->setAccessible(true);
$keyProperty->setAccessible(true);

$url = $urlProperty->getValue($supabase);
$key = $keyProperty->getValue($supabase);

echo "<p><strong>URL:</strong> " . $url . "</p>";
echo "<p><strong>API Key:</strong> " . substr($key, 0, 20) . "...</p>";

// Test de conexión básica
echo "<h2>2. Test de conexión básica:</h2>";
$testUrl = $url . '/rest/v1/Property?select=*&limit=1';

echo "<p><strong>URL de test:</strong> " . $testUrl . "</p>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $testUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'apikey: ' . $key,
    'Authorization: Bearer ' . $key
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "<p><strong>HTTP Status:</strong> " . $httpCode . "</p>";
echo "<p><strong>cURL Error:</strong> " . ($error ?: 'Ninguno') . "</p>";
echo "<p><strong>Response:</strong> " . substr($response, 0, 500) . "</p>";

if ($httpCode === 200) {
    echo "<p style='color: green;'><strong>✅ Conexión exitosa</strong></p>";
    
    $data = json_decode($response, true);
    if (!empty($data)) {
        echo "<h2>3. Propiedades encontradas:</h2>";
        foreach ($data as $property) {
            echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
            echo "<h3>" . htmlspecialchars($property['title']) . "</h3>";
            echo "<p><strong>Precio:</strong> " . number_format($property['price']) . "€</p>";
            echo "<p><strong>Ubicación:</strong> " . htmlspecialchars($property['location']) . "</p>";
            echo "<p><strong>Tipo:</strong> " . htmlspecialchars($property['type']) . "</p>";
            echo "<p><strong>Estado:</strong> " . htmlspecialchars($property['status']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p style='color: orange;'><strong>⚠️ No hay propiedades en la base de datos</strong></p>";
    }
} else {
    echo "<p style='color: red;'><strong>❌ Error en la conexión</strong></p>";
    
    // Información adicional de debug
    echo "<h2>4. Información de debug:</h2>";
    echo "<p><strong>Total time:</strong> " . $info['total_time'] . "s</p>";
    echo "<p><strong>Connect time:</strong> " . $info['connect_time'] . "s</p>";
    echo "<p><strong>Name lookup time:</strong> " . $info['namelookup_time'] . "s</p>";
}
?>
