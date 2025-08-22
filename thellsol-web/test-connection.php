<?php
require_once 'supabase-connection.php';

echo "<h1>Test de Conexión con Supabase</h1>";

try {
    $supabase = new SupabaseConnection();
    
    echo "<h2>Probando conexión...</h2>";
    
    // Probar obtener propiedades
    $result = $supabase->getProperties();
    
    echo "<h3>Resultado de la conexión:</h3>";
    echo "<pre>";
    print_r($result);
    echo "</pre>";
    
    if ($result['status'] === 200) {
        echo "<div style='color: green; font-weight: bold;'>✅ Conexión exitosa con Supabase!</div>";
        
        if (!empty($result['data'])) {
            echo "<h3>Propiedades encontradas:</h3>";
            echo "<ul>";
            foreach ($result['data'] as $property) {
                echo "<li><strong>" . htmlspecialchars($property['title']) . "</strong> - " . number_format($property['price']) . "€</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No hay propiedades en la base de datos aún.</p>";
        }
    } else {
        echo "<div style='color: red; font-weight: bold;'>❌ Error en la conexión. Status: " . $result['status'] . "</div>";
    }
    
} catch (Exception $e) {
    echo "<div style='color: red; font-weight: bold;'>❌ Error: " . $e->getMessage() . "</div>";
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f5f5f5;
}
h1 {
    color: #181e29;
    text-align: center;
}
h2, h3 {
    color: #0070f3;
}
pre {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    overflow-x: auto;
}
ul {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
li {
    margin-bottom: 10px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 5px;
}
</style>
