<?php
// Actualizar TODOS los archivos con la configuración correcta
// Archivo: actualizar-todo.php

echo "<h1>🔄 Actualización Completa de Configuración</h1>";

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

// Archivos a actualizar
$archivos = [
    'dashboard-api.php',
    'supabase-connection.php',
    'admin-dashboard.php',
    'index.php',
    'comprar.php',
    'propiedades-dinamicas.php',
    'test-dashboard-supabase.php',
    'test-supabase-connection.php',
    'test-supabase-simple.php',
    'test-supabase-fixed.php',
    'test-supabase.php'
];

echo "<h2>📋 Archivos a actualizar:</h2>";
echo "<ul>";
foreach ($archivos as $archivo) {
    echo "<li>$archivo</li>";
}
echo "</ul>";

echo "<h2>🔧 Proceso de actualización:</h2>";

$actualizados = 0;
$errores = 0;

foreach ($archivos as $archivo) {
    echo "<h3>📄 Actualizando: $archivo</h3>";
    
    if (!file_exists($archivo)) {
        echo "<p style='color: orange;'>⚠️ Archivo no encontrado, saltando...</p>";
        continue;
    }
    
    // Crear backup
    $backup = $archivo . '.backup.' . date('Y-m-d_H-i-s');
    if (copy($archivo, $backup)) {
        echo "<p>💾 Backup creado: $backup</p>";
    }
    
    // Leer contenido
    $contenido = file_get_contents($archivo);
    $contenidoOriginal = $contenido;
    
    // Reemplazar URL
    $contenido = str_replace($configAntigua['url'], $configCorrecta['url'], $contenido);
    
    // Reemplazar Key (más complejo porque puede estar en diferentes formatos)
    $contenido = str_replace($configAntigua['key'], $configCorrecta['key'], $contenido);
    
    // Verificar si hubo cambios
    if ($contenido !== $contenidoOriginal) {
        // Guardar archivo actualizado
        if (file_put_contents($archivo, $contenido)) {
            echo "<p style='color: green;'>✅ Archivo actualizado exitosamente</p>";
            $actualizados++;
        } else {
            echo "<p style='color: red;'>❌ Error al guardar el archivo</p>";
            $errores++;
        }
    } else {
        echo "<p style='color: blue;'>ℹ️ No se encontraron cambios necesarios</p>";
    }
    
    echo "<hr>";
}

echo "<h2>📊 Resumen de la actualización:</h2>";
echo "<p><strong>Archivos actualizados:</strong> $actualizados</p>";
echo "<p><strong>Errores:</strong> $errores</p>";

if ($actualizados > 0) {
    echo "<h3>✅ Actualización completada</h3>";
    echo "<p>Ahora todos los archivos usan la configuración correcta de Supabase.</p>";
    
    echo "<h3>🧪 Próximos pasos:</h3>";
    echo "<ol>";
    echo "<li>Prueba la conexión: <a href='test-simple.html' target='_blank'>Test de conexión</a></li>";
    echo "<li>Verifica el dashboard: <a href='admin-dashboard.php' target='_blank'>Dashboard</a></li>";
    echo "<li>Revisa la página principal: <a href='index.php' target='_blank'>Página principal</a></li>";
    echo "</ol>";
    
    echo "<h3>🔍 Si aún hay problemas:</h3>";
    echo "<p>Ejecuta el diagnóstico completo: <a href='diagnostico-completo.php' target='_blank'>Diagnóstico</a></p>";
} else {
    echo "<h3>⚠️ No se realizaron cambios</h3>";
    echo "<p>Parece que los archivos ya tenían la configuración correcta o no se encontraron las configuraciones antiguas.</p>";
}

// Test inmediato de conexión
echo "<h2>🧪 Test inmediato de conexión:</h2>";

function testConnection() {
    global $configCorrecta;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $configCorrecta['url'] . '/rest/v1/Property?select=*&limit=5');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'apikey: ' . $configCorrecta['key'],
        'Authorization: Bearer ' . $configCorrecta['key']
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        $count = is_array($data) ? count($data) : 0;
        echo "<p style='color: green;'>✅ Conexión exitosa con Supabase</p>";
        echo "<p><strong>Propiedades encontradas:</strong> $count</p>";
        
        if ($count > 0) {
            echo "<p><strong>Primeras propiedades:</strong></p>";
            echo "<ul>";
            foreach (array_slice($data, 0, 3) as $prop) {
                echo "<li>" . htmlspecialchars($prop['title'] ?? 'Sin título') . " - " . number_format($prop['price'] ?? 0) . "€</li>";
            }
            echo "</ul>";
        }
        return true;
    } else {
        echo "<p style='color: red;'>❌ Error de conexión (HTTP $httpCode)</p>";
        return false;
    }
}

testConnection();
?>
