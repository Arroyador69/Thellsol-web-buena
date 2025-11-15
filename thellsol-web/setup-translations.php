<?php
// Script para crear tabla de traducciones e insertar datos
// Ejecutar una vez: https://thellsol.com/setup-translations.php

require_once 'db-config.php';

$conn = getDBConnection();
$messages = [];

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Setup Translations</title>";
echo "<style>body{font-family:Arial;max-width:800px;margin:50px auto;padding:20px;}";
echo ".success{background:#d4edda;color:#155724;padding:15px;border-radius:5px;margin:10px 0;}";
echo ".error{background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;margin:10px 0;}";
echo ".info{background:#d1ecf1;color:#0c5460;padding:15px;border-radius:5px;margin:10px 0;}";
echo "</style></head><body>";
echo "<h1>🌍 Configuración del Sistema de Traducciones</h1>";

// 1. Crear tabla
echo "<h2>1. Creando tabla translations...</h2>";
$createTableSQL = "
CREATE TABLE IF NOT EXISTS translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lang_code VARCHAR(5) NOT NULL,
    translation_key VARCHAR(100) NOT NULL,
    translation_value TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_translation (lang_code, translation_key),
    INDEX idx_lang_code (lang_code),
    INDEX idx_translation_key (translation_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

if ($conn->query($createTableSQL)) {
    echo "<div class='success'>✅ Tabla 'translations' creada exitosamente</div>";
} else {
    echo "<div class='error'>❌ Error al crear tabla: " . $conn->error . "</div>";
}

// 2. Leer e insertar traducciones desde SQL
echo "<h2>2. Insertando traducciones...</h2>";
$sqlFile = 'insert-translations.sql';
if (file_exists($sqlFile)) {
    $sql = file_get_contents($sqlFile);
    // Dividir en statements individuales
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    $inserted = 0;
    $errors = 0;
    
    foreach ($statements as $statement) {
        if (!empty($statement) && stripos($statement, 'INSERT') === 0) {
            if ($conn->query($statement)) {
                $inserted++;
            } else {
                // Ignorar errores de duplicados
                if (strpos($conn->error, 'Duplicate') === false) {
                    $errors++;
                    echo "<div class='error'>Error: " . $conn->error . "</div>";
                }
            }
        }
    }
    
    echo "<div class='success'>✅ Insertadas $inserted traducciones</div>";
    if ($errors > 0) {
        echo "<div class='error'>❌ $errors errores encontrados</div>";
    }
} else {
    echo "<div class='error'>❌ Archivo insert-translations.sql no encontrado</div>";
}

// 3. Verificar traducciones
echo "<h2>3. Verificando traducciones...</h2>";
$langs = ['es', 'en', 'fr', 'ru', 'sv'];
foreach ($langs as $lang) {
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM translations WHERE lang_code = ?");
    $stmt->bind_param("s", $lang);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo "<div class='info'>📊 $lang: {$row['count']} traducciones</div>";
    $stmt->close();
}

echo "<hr>";
echo "<h2>✅ Configuración completada</h2>";
echo "<p>El sistema de traducciones está listo para usar.</p>";
echo "<p><a href='index.php'>← Volver a la página principal</a></p>";
echo "</body></html>";
?>

