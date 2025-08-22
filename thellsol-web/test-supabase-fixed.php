<?php
require_once 'supabase-connection-fixed.php';

echo "<h1>Test de Conexión Supabase - Versión Mejorada</h1>";

try {
    $supabase = new SupabaseConnectionFixed();
    $result = $supabase->getProperties();
    
    echo "<h2>Estado de la conexión:</h2>";
    echo "<p><strong>HTTP Status:</strong> " . $result['status'] . "</p>";
    
    if (isset($result['error'])) {
        echo "<p style='color: red;'><strong>❌ Error:</strong> " . $result['error'] . "</p>";
    }
    
    if ($result['status'] === 200) {
        echo "<p style='color: green;'><strong>✅ Conexión exitosa</strong></p>";
        
        if (!empty($result['data'])) {
            echo "<h2>Propiedades encontradas (" . count($result['data']) . "):</h2>";
            foreach ($result['data'] as $property) {
                echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
                echo "<h3>" . htmlspecialchars($property['title']) . "</h3>";
                echo "<p><strong>Precio:</strong> " . number_format($property['price']) . "€</p>";
                echo "<p><strong>Ubicación:</strong> " . htmlspecialchars($property['location']) . "</p>";
                echo "<p><strong>Tipo:</strong> " . htmlspecialchars($property['type']) . "</p>";
                echo "<p><strong>Estado:</strong> " . htmlspecialchars($property['status']) . "</p>";
                echo "<p><strong>ID:</strong> " . $property['id'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p style='color: orange;'><strong>⚠️ No hay propiedades en la base de datos</strong></p>";
        }
    } else {
        echo "<p style='color: red;'><strong>❌ Error en la conexión</strong></p>";
        if (isset($result['raw_response'])) {
            echo "<p><strong>Respuesta:</strong> " . substr($result['raw_response'], 0, 500) . "</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>❌ Error:</strong> " . $e->getMessage() . "</p>";
}
?>
