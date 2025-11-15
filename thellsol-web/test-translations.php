<?php
// Script de prueba para verificar conexión y tabla
require_once 'db-config.php';

$conn = getDBConnection();

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Test Translations</title>";
echo "<style>body{font-family:Arial;max-width:900px;margin:50px auto;padding:20px;}";
echo ".success{background:#d4edda;color:#155724;padding:15px;border-radius:5px;margin:10px 0;}";
echo ".error{background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;margin:10px 0;}";
echo ".info{background:#d1ecf1;color:#0c5460;padding:15px;border-radius:5px;margin:10px 0;}";
echo "pre{background:#f5f5f5;padding:10px;border-radius:5px;overflow-x:auto;}";
echo "</style></head><body>";
echo "<h1>🔍 Test de Conexión y Tabla Translations</h1>";

// 1. Verificar conexión
echo "<h2>1. Verificación de Conexión</h2>";
if ($conn->connect_error) {
    echo "<div class='error'>❌ Error de conexión: " . $conn->connect_error . "</div>";
    exit;
} else {
    echo "<div class='success'>✅ Conexión exitosa a la base de datos</div>";
}

// 2. Verificar que la tabla existe
echo "<h2>2. Verificación de Tabla</h2>";
$result = $conn->query("SHOW TABLES LIKE 'translations'");
if ($result->num_rows > 0) {
    echo "<div class='success'>✅ La tabla 'translations' existe</div>";
    
    // Ver estructura
    $structure = $conn->query("DESCRIBE translations");
    echo "<h3>Estructura de la tabla:</h3><pre>";
    while ($row = $structure->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
    echo "</pre>";
} else {
    echo "<div class='error'>❌ La tabla 'translations' NO existe</div>";
    echo "<p>Ejecuta primero: <code>create-translations-table.sql</code></p>";
}

// 3. Contar registros actuales
echo "<h2>3. Registros Actuales</h2>";
$count = $conn->query("SELECT COUNT(*) as total FROM translations");
if ($count) {
    $row = $count->fetch_assoc();
    echo "<div class='info'>📊 Total de traducciones: " . $row['total'] . "</div>";
} else {
    echo "<div class='error'>❌ Error al contar: " . $conn->error . "</div>";
}

// 4. Probar inserción de una traducción de prueba
echo "<h2>4. Prueba de Inserción</h2>";
$testKey = 'test.key';
$testLang = 'es';
$testValue = 'Valor de prueba';

// Eliminar si existe
$conn->query("DELETE FROM translations WHERE lang_code = '$testLang' AND translation_key = '$testKey'");

$stmt = $conn->prepare("INSERT INTO translations (lang_code, translation_key, translation_value) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $testLang, $testKey, $testValue);

if ($stmt->execute()) {
    echo "<div class='success'>✅ Inserción de prueba exitosa</div>";
    
    // Verificar que se insertó
    $verify = $conn->query("SELECT * FROM translations WHERE lang_code = '$testLang' AND translation_key = '$testKey'");
    if ($verify->num_rows > 0) {
        $data = $verify->fetch_assoc();
        echo "<div class='info'>✅ Verificación: Se encontró el registro insertado</div>";
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
    
    // Eliminar prueba
    $conn->query("DELETE FROM translations WHERE lang_code = '$testLang' AND translation_key = '$testKey'");
    echo "<div class='info'>🧹 Registro de prueba eliminado</div>";
} else {
    echo "<div class='error'>❌ Error en inserción de prueba: " . $stmt->error . "</div>";
}
$stmt->close();

// 5. Verificar permisos
echo "<h2>5. Verificación de Permisos</h2>";
$perms = $conn->query("SHOW GRANTS");
if ($perms) {
    echo "<div class='info'>Permisos del usuario:</div><pre>";
    while ($row = $perms->fetch_row()) {
        echo $row[0] . "\n";
    }
    echo "</pre>";
}

echo "<hr>";
echo "<h2>📋 Próximos Pasos</h2>";
echo "<p>Si todo está correcto, ejecuta: <a href='insert-translations-direct.php'>insert-translations-direct.php</a></p>";
echo "</body></html>";
?>

