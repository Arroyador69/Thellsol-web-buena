<?php
// Verificar la estructura de la tabla Property en Supabase
// Archivo: verificar-tabla.php

echo "<h1>🔍 Verificar Estructura de la Tabla Property</h1>";

// Configuración CORRECTA
$supabaseUrl = 'https://hhfkutuhvsjfbrwozvdq.supabase.co';
$supabaseKey = 'sb_publishable_2uC8yz0GQ17I58xtqtH6gw_5QUAc9KK';

echo "<h2>📋 Configuración:</h2>";
echo "<p><strong>URL:</strong> $supabaseUrl</p>";
echo "<p><strong>Key:</strong> " . substr($supabaseKey, 0, 20) . "...</p>";

// Función para hacer peticiones a Supabase
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

echo "<h2>🧪 Test 1: Verificar si la tabla Property existe</h2>";

// Probar diferentes nombres de tabla
$tablas = ['Property', 'property', 'properties', 'Properties', 'propiedades'];

foreach ($tablas as $tabla) {
    echo "<h3>📄 Probando tabla: $tabla</h3>";
    
    $result = makeSupabaseRequest($tabla . '?select=*&limit=1');
    
    if ($result['success']) {
        echo "<p style='color: green;'>✅ Tabla '$tabla' existe y es accesible</p>";
        echo "<p><strong>Código HTTP:</strong> " . $result['status'] . "</p>";
        
        // Obtener todas las propiedades de esta tabla
        $resultAll = makeSupabaseRequest($tabla . '?select=*&order=createdAt.desc');
        
        if ($resultAll['success']) {
            $properties = $resultAll['data'] ?? [];
            echo "<p><strong>Total de propiedades en '$tabla':</strong> " . count($properties) . "</p>";
            
            if (count($properties) > 0) {
                echo "<p style='color: green; font-weight: bold;'>🎯 ¡ENCONTRADAS PROPIEDADES EN LA TABLA '$tabla'!</p>";
                
                echo "<h4>📋 Primeras propiedades:</h4>";
                echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-top: 10px;'>";
                echo "<tr style='background: #f0f0f0;'>";
                echo "<th>ID</th><th>Título</th><th>Precio</th><th>Ubicación</th><th>Tipo</th><th>Estado</th>";
                echo "</tr>";
                
                foreach (array_slice($properties, 0, 5) as $property) {
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
                
                // Mostrar estructura de la primera propiedad
                echo "<h4>🏗️ Estructura de datos:</h4>";
                echo "<pre style='background: #f8f8f8; padding: 15px; border-radius: 4px; overflow-x: auto;'>";
                echo json_encode($properties[0], JSON_PRETTY_PRINT);
                echo "</pre>";
                
                // Guardar la tabla correcta
                $tablaCorrecta = $tabla;
                break;
            } else {
                echo "<p style='color: orange;'>⚠️ La tabla '$tabla' existe pero está vacía</p>";
            }
        }
    } else {
        echo "<p style='color: red;'>❌ Tabla '$tabla' no existe o no es accesible</p>";
        echo "<p><strong>Error:</strong> " . $result['error'] . "</p>";
        echo "<p><strong>Código HTTP:</strong> " . $result['status'] . "</p>";
    }
    
    echo "<hr>";
}

echo "<h2>🔧 Test 2: Verificar esquema de la base de datos</h2>";

// Intentar obtener información del esquema
$result = makeSupabaseRequest('?select=*&limit=1');

if ($result['success']) {
    echo "<p style='color: green;'>✅ Conexión a la base de datos exitosa</p>";
    echo "<p><strong>Respuesta:</strong></p>";
    echo "<pre style='background: #f8f8f8; padding: 15px; border-radius: 4px;'>";
    echo htmlspecialchars($result['raw_response']);
    echo "</pre>";
} else {
    echo "<p style='color: red;'>❌ Error al conectar con la base de datos</p>";
    echo "<p><strong>Error:</strong> " . $result['error'] . "</p>";
}

echo "<h2>🎯 Solución si se encontró la tabla correcta</h2>";

if (isset($tablaCorrecta) && $tablaCorrecta !== 'Property') {
    echo "<p style='color: green; font-weight: bold;'>¡PROBLEMA IDENTIFICADO!</p>";
    echo "<p>La tabla correcta es '$tablaCorrecta', no 'Property'.</p>";
    
    echo "<h3>🔧 Actualizar archivos con la tabla correcta:</h3>";
    
    // Archivos a actualizar
    $archivos = [
        'dashboard-api.php',
        'supabase-connection.php',
        'admin-dashboard.php'
    ];
    
    foreach ($archivos as $archivo) {
        echo "<h4>📄 $archivo</h4>";
        
        if (file_exists($archivo)) {
            // Crear backup
            $backup = $archivo . '.backup.' . date('Y-m-d_H-i-s');
            copy($archivo, $backup);
            echo "<p>💾 Backup creado: $backup</p>";
            
            // Leer contenido
            $contenido = file_get_contents($archivo);
            
            // Reemplazar 'Property' por la tabla correcta
            $contenido = str_replace('Property', $tablaCorrecta, $contenido);
            
            // Guardar archivo
            if (file_put_contents($archivo, $contenido)) {
                echo "<p style='color: green;'>✅ Archivo actualizado con tabla '$tablaCorrecta'</p>";
            } else {
                echo "<p style='color: red;'>❌ Error al guardar el archivo</p>";
            }
        } else {
            echo "<p style='color: orange;'>⚠️ Archivo no encontrado</p>";
        }
        
        echo "<hr>";
    }
    
    echo "<h3>🧪 Test final con la tabla correcta:</h3>";
    
    $result = makeSupabaseRequest($tablaCorrecta . '?select=*&limit=5');
    
    if ($result['success']) {
        $properties = $result['data'] ?? [];
        echo "<p style='color: green;'>✅ Conexión exitosa con tabla '$tablaCorrecta'</p>";
        echo "<p><strong>Propiedades encontradas:</strong> " . count($properties) . "</p>";
        
        echo "<h3>🔗 Enlaces para verificar:</h3>";
        echo "<ul>";
        echo "<li><a href='index.php' target='_blank'>Página principal</a></li>";
        echo "<li><a href='comprar.php' target='_blank'>Página de comprar</a></li>";
        echo "<li><a href='test-simple.html' target='_blank'>Test de conexión</a></li>";
        echo "</ul>";
    }
} else {
    echo "<p>No se encontró una tabla con propiedades. El problema puede estar en:</p>";
    echo "<ul>";
    echo "<li>Credenciales incorrectas</li>";
    echo "<li>Base de datos diferente</li>";
    echo "<li>Permisos insuficientes</li>";
    echo "<li>Tabla con nombre diferente</li>";
    echo "</ul>";
}

echo "<h2>📋 Resumen del diagnóstico:</h2>";
echo "<ul>";
if (isset($tablaCorrecta)) {
    echo "<li>✅ Tabla encontrada: $tablaCorrecta</li>";
    echo "<li>✅ Propiedades disponibles</li>";
    echo "<li>✅ Archivos actualizados</li>";
} else {
    echo "<li>❌ No se encontró tabla con propiedades</li>";
    echo "<li>❌ Problema de conexión o credenciales</li>";
}
echo "</ul>";
?>
