<?php
// Verificar configuración de Supabase en todos los archivos
// Archivo: verificar-configuracion.php

echo "<h1>🔧 Verificación de Configuración Supabase</h1>";

// Configuración CORRECTA
$configCorrecta = [
    'url' => 'https://hhfkutuhvsjfbrwozvdq.supabase.co',
    'key' => 'sb_publishable_2uC8yz0GQ17I58xtqtH6gw_5QUAc9KK'
];

// Configuración ANTIGUA (incorrecta)
$configAntigua = [
    'url' => 'https://spdwjdrlemselkqbxau.supabase.co',
    'key' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InNwZHdqZHJsZW1zZWxrcWJ4YXVlIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTU2MTU0MzcsImV4cCI6MjA3MTE5MTQzN30.BzX55tzKeSGEL9D7wgJG4M-DCcmQ3K4fZjcHR-LMnAs'
];

// Archivos a verificar
$archivos = [
    'dashboard-api.php',
    'supabase-connection.php',
    'supabase-config-correct.php',
    'admin-dashboard.php',
    'index.php',
    'comprar.php'
];

echo "<h2>📋 Configuración Correcta:</h2>";
echo "<p><strong>URL:</strong> " . $configCorrecta['url'] . "</p>";
echo "<p><strong>Key:</strong> " . substr($configCorrecta['key'], 0, 20) . "...</p>";

echo "<h2>🔍 Verificando Archivos:</h2>";

foreach ($archivos as $archivo) {
    echo "<h3>📄 $archivo</h3>";
    
    if (!file_exists($archivo)) {
        echo "<p style='color: red;'>❌ Archivo no encontrado</p>";
        continue;
    }
    
    $contenido = file_get_contents($archivo);
    
    // Verificar URL
    $tieneUrlCorrecta = strpos($contenido, $configCorrecta['url']) !== false;
    $tieneUrlAntigua = strpos($contenido, $configAntigua['url']) !== false;
    
    // Verificar Key
    $tieneKeyCorrecta = strpos($contenido, $configCorrecta['key']) !== false;
    $tieneKeyAntigua = strpos($contenido, $configAntigua['key']) !== false;
    
    echo "<p><strong>URL:</strong> ";
    if ($tieneUrlCorrecta) {
        echo "<span style='color: green;'>✅ Correcta</span>";
    } elseif ($tieneUrlAntigua) {
        echo "<span style='color: red;'>❌ Antigua (necesita actualización)</span>";
    } else {
        echo "<span style='color: orange;'>⚠️ No encontrada</span>";
    }
    echo "</p>";
    
    echo "<p><strong>Key:</strong> ";
    if ($tieneKeyCorrecta) {
        echo "<span style='color: green;'>✅ Correcta</span>";
    } elseif ($tieneKeyAntigua) {
        echo "<span style='color: red;'>❌ Antigua (necesita actualización)</span>";
    } else {
        echo "<span style='color: orange;'>⚠️ No encontrada</span>";
    }
    echo "</p>";
    
    // Mostrar líneas relevantes
    $lineas = explode("\n", $contenido);
    $lineasRelevantes = [];
    
    foreach ($lineas as $numero => $linea) {
        if (strpos($linea, 'supabase') !== false || strpos($linea, 'Supabase') !== false) {
            $lineasRelevantes[] = ($numero + 1) . ": " . htmlspecialchars(trim($linea));
        }
    }
    
    if (!empty($lineasRelevantes)) {
        echo "<p><strong>Líneas relevantes:</strong></p>";
        echo "<pre style='background: #f8f8f8; padding: 10px; border-radius: 4px;'>";
        foreach (array_slice($lineasRelevantes, 0, 5) as $linea) {
            echo $linea . "\n";
        }
        if (count($lineasRelevantes) > 5) {
            echo "... y " . (count($lineasRelevantes) - 5) . " líneas más\n";
        }
        echo "</pre>";
    }
    
    echo "<hr>";
}

// Test de conexión
echo "<h2>🧪 Test de Conexión con Configuración Actual</h2>";

function testSupabaseConnection($url, $key) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . '/rest/v1/Property?select=*&limit=1');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'apikey: ' . $key,
        'Authorization: Bearer ' . $key
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    return [
        'success' => $httpCode === 200,
        'status' => $httpCode,
        'error' => $error,
        'response' => $response
    ];
}

$resultado = testSupabaseConnection($configCorrecta['url'], $configCorrecta['key']);

if ($resultado['success']) {
    echo "<p style='color: green;'>✅ Conexión exitosa con Supabase</p>";
    echo "<p><strong>Código HTTP:</strong> " . $resultado['status'] . "</p>";
} else {
    echo "<p style='color: red;'>❌ Error de conexión</p>";
    echo "<p><strong>Error:</strong> " . $resultado['error'] . "</p>";
    echo "<p><strong>Código HTTP:</strong> " . $resultado['status'] . "</p>";
}

echo "<h2>📋 Resumen y Recomendaciones</h2>";

echo "<h3>✅ Archivos que necesitan actualización:</h3>";
echo "<p>Si algún archivo muestra '❌ Antigua', necesita ser actualizado con la configuración correcta.</p>";

echo "<h3>🔧 Comandos para actualizar:</h3>";
echo "<pre style='background: #f8f8f8; padding: 15px; border-radius: 4px;'>";
echo "# Para actualizar dashboard-api.php:\n";
echo "sed -i 's|https://spdwjdrlemselkqbxau.supabase.co|https://hhfkutuhvsjfbrwozvdq.supabase.co|g' dashboard-api.php\n";
echo "sed -i 's|eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.*|sb_publishable_2uC8yz0GQ17I58xtqtH6gw_5QUAc9KK|g' dashboard-api.php\n";
echo "</pre>";

echo "<h3>📞 Próximos pasos:</h3>";
echo "<ol>";
echo "<li>Verifica que todos los archivos tengan la configuración correcta</li>";
echo "<li>Si hay archivos con configuración antigua, actualízalos</li>";
echo "<li>Prueba la conexión con el script de test</li>";
echo "<li>Verifica que las propiedades aparezcan en la web</li>";
echo "</ol>";
?>
