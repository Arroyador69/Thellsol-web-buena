<?php
// Diagnóstico completo del problema de propiedades
// Archivo: diagnostico-completo.php

echo "<h1>🔍 Diagnóstico Completo - Problema de Propiedades</h1>";

// Configuración CORRECTA
$configCorrecta = [
    'url' => 'https://hhfkutuhvsjfbrwozvdq.supabase.co',
    'key' => 'sb_publishable_2uC8yz0GQ17I58xtqtH6gw_5QUAc9KK'
];

// Configuración ANTIGUA
$configAntigua = [
    'url' => 'https://spdwjdrlemselkqbxau.supabase.co',
    'key' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InNwZHdqZHJsZW1zZWxrcWJ4YXVlIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTU2MTU0MzcsImV4cCI6MjA3MTE5MTQzN30.BzX55tzKeSGEL9D7wgJG4M-DCcmQ3K4fZjcHR-LMnAs'
];

function testSupabaseConnection($url, $key, $nombre) {
    echo "<h3>🧪 Test: $nombre</h3>";
    echo "<p><strong>URL:</strong> $url</p>";
    echo "<p><strong>Key:</strong> " . substr($key, 0, 20) . "...</p>";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . '/rest/v1/Property?select=*&order=createdAt.desc');
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
    
    if ($error) {
        echo "<p style='color: red;'>❌ Error de cURL: $error</p>";
        return false;
    }
    
    echo "<p><strong>Código HTTP:</strong> $httpCode</p>";
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        $count = is_array($data) ? count($data) : 0;
        echo "<p style='color: green;'>✅ Conexión exitosa</p>";
        echo "<p><strong>Propiedades encontradas:</strong> $count</p>";
        
        if ($count > 0) {
            echo "<p><strong>Primera propiedad:</strong></p>";
            echo "<pre style='background: #f8f8f8; padding: 10px; border-radius: 4px;'>";
            echo json_encode($data[0], JSON_PRETTY_PRINT);
            echo "</pre>";
        }
        return true;
    } else {
        echo "<p style='color: red;'>❌ Error HTTP: $httpCode</p>";
        echo "<p><strong>Respuesta:</strong></p>";
        echo "<pre style='background: #f8f8f8; padding: 10px; border-radius: 4px;'>";
        echo htmlspecialchars($response);
        echo "</pre>";
        return false;
    }
}

echo "<h2>🔧 Verificando Configuraciones</h2>";

// Test 1: Configuración CORRECTA
$test1 = testSupabaseConnection($configCorrecta['url'], $configCorrecta['key'], "Configuración CORRECTA");

echo "<hr>";

// Test 2: Configuración ANTIGUA
$test2 = testSupabaseConnection($configAntigua['url'], $configAntigua['key'], "Configuración ANTIGUA");

echo "<hr>";

// Verificar archivos
echo "<h2>📄 Verificando Archivos</h2>";

$archivos = [
    'dashboard-api.php',
    'supabase-connection.php',
    'admin-dashboard.php'
];

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
        echo "<span style='color: red;'>❌ Antigua</span>";
    } else {
        echo "<span style='color: orange;'>⚠️ No encontrada</span>";
    }
    echo "</p>";
    
    echo "<p><strong>Key:</strong> ";
    if ($tieneKeyCorrecta) {
        echo "<span style='color: green;'>✅ Correcta</span>";
    } elseif ($tieneKeyAntigua) {
        echo "<span style='color: red;'>❌ Antigua</span>";
    } else {
        echo "<span style='color: orange;'>⚠️ No encontrada</span>";
    }
    echo "</p>";
}

echo "<h2>🎯 Solución Inmediata</h2>";

if ($test1 && !$test2) {
    echo "<p style='color: green;'>✅ La configuración CORRECTA funciona y tiene propiedades</p>";
    echo "<p style='color: red;'>❌ La configuración ANTIGUA no funciona</p>";
    echo "<p><strong>Problema:</strong> El dashboard está usando la configuración ANTIGUA</p>";
} elseif (!$test1 && $test2) {
    echo "<p style='color: red;'>❌ La configuración CORRECTA no funciona</p>";
    echo "<p style='color: green;'>✅ La configuración ANTIGUA funciona y tiene propiedades</p>";
    echo "<p><strong>Problema:</strong> Necesitamos usar la configuración ANTIGUA</p>";
} elseif ($test1 && $test2) {
    echo "<p style='color: green;'>✅ Ambas configuraciones funcionan</p>";
    echo "<p><strong>Problema:</strong> Inconsistencia en la configuración</p>";
} else {
    echo "<p style='color: red;'>❌ Ninguna configuración funciona</p>";
    echo "<p><strong>Problema:</strong> Error de conexión con Supabase</p>";
}

echo "<h3>🔧 Acción Inmediata:</h3>";
echo "<p>Ejecuta este script para actualizar TODOS los archivos con la configuración correcta:</p>";
echo "<a href='actualizar-todo.php' style='background: #0070f3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;'>🔄 Actualizar Todo</a>";
?>
