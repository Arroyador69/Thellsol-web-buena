<?php
// Script de prueba del sistema de traducciones
// Visita: https://thellsol.com/test-language-system.php

require_once 'db-config.php';
require_once 'translations.php';

$conn = getDBConnection();

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Test Language System</title>";
echo "<style>body{font-family:Arial;max-width:1000px;margin:50px auto;padding:20px;}";
echo ".success{background:#d4edda;color:#155724;padding:15px;border-radius:5px;margin:10px 0;}";
echo ".error{background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;margin:10px 0;}";
echo ".info{background:#d1ecf1;color:#0c5460;padding:15px;border-radius:5px;margin:10px 0;}";
echo ".test-section{border:2px solid #ddd;padding:20px;margin:20px 0;border-radius:8px;}";
echo "table{border-collapse:collapse;width:100%;margin:10px 0;}";
echo "th,td{border:1px solid #ddd;padding:8px;text-align:left;}";
echo "th{background:#667eea;color:white;}";
echo "</style></head><body>";
echo "<h1>🌍 Test del Sistema de Traducciones</h1>";

// 1. Verificar conexión
echo "<div class='test-section'>";
echo "<h2>1. Verificación de Conexión</h2>";
if ($conn->connect_error) {
    echo "<div class='error'>❌ Error de conexión: " . $conn->connect_error . "</div>";
} else {
    echo "<div class='success'>✅ Conexión exitosa</div>";
}
echo "</div>";

// 2. Verificar tabla
echo "<div class='test-section'>";
echo "<h2>2. Verificación de Tabla Translations</h2>";
$tableCheck = $conn->query("SHOW TABLES LIKE 'translations'");
if ($tableCheck->num_rows === 0) {
    echo "<div class='error'>❌ La tabla 'translations' no existe</div>";
} else {
    echo "<div class='success'>✅ Tabla 'translations' existe</div>";
    
    // Contar traducciones por idioma
    $langs = ['en', 'es', 'fr', 'ru', 'sv'];
    echo "<h3>Traducciones por idioma:</h3><table><tr><th>Idioma</th><th>Cantidad</th></tr>";
    foreach ($langs as $lang) {
        $count = $conn->query("SELECT COUNT(*) as total FROM translations WHERE lang_code = '$lang'");
        $row = $count->fetch_assoc();
        echo "<tr><td><strong>$lang</strong></td><td>{$row['total']} traducciones</td></tr>";
    }
    echo "</table>";
}
echo "</div>";

// 3. Probar función getCurrentLanguage()
echo "<div class='test-section'>";
echo "<h2>3. Test de getCurrentLanguage()</h2>";
$currentLang = getCurrentLanguage();
echo "<div class='info'>Idioma actual detectado: <strong>$currentLang</strong></div>";
echo "<div class='info'>Idioma por defecto configurado: <strong>" . DEFAULT_LANGUAGE . "</strong></div>";
if ($currentLang === DEFAULT_LANGUAGE) {
    echo "<div class='success'>✅ Idioma por defecto correcto (inglés)</div>";
} else {
    echo "<div class='info'>ℹ️ Idioma actual: $currentLang (puede ser por sesión/cookie)</div>";
}
echo "</div>";

// 4. Probar función t() con diferentes idiomas
echo "<div class='test-section'>";
echo "<h2>4. Test de Traducciones</h2>";
$testKeys = ['nav.home', 'nav.buy', 'nav.sell', 'nav.legal', 'nav.contact', 'home.welcome', 'home.featured'];

echo "<h3>Probando traducciones en diferentes idiomas:</h3>";
echo "<table><tr><th>Key</th><th>English (en)</th><th>Español (es)</th><th>Français (fr)</th><th>Русский (ru)</th><th>Svenska (sv)</th></tr>";

foreach ($testKeys as $key) {
    echo "<tr>";
    echo "<td><strong>$key</strong></td>";
    
    // Probar cada idioma
    foreach (['en', 'es', 'fr', 'ru', 'sv'] as $lang) {
        // Cambiar idioma temporalmente
        $_SESSION['lang'] = $lang;
        $translation = t($key);
        echo "<td>" . htmlspecialchars($translation) . "</td>";
    }
    
    echo "</tr>";
}

// Restaurar idioma original
$_SESSION['lang'] = $currentLang;

echo "</table>";
echo "</div>";

// 5. Probar selector de idiomas
echo "<div class='test-section'>";
echo "<h2>5. Test del Selector de Idiomas</h2>";
echo "<p>El selector debería aparecer abajo con las banderas:</p>";
include 'language-selector.php';
echo "</div>";

// 6. Verificar traducciones específicas
echo "<div class='test-section'>";
echo "<h2>6. Verificación de Traducciones Específicas</h2>";
$requiredKeys = [
    'nav.home', 'nav.buy', 'nav.sell', 'nav.legal', 'nav.contact',
    'home.welcome', 'home.intro', 'home.featured', 'home.viewDetails'
];

$missing = [];
foreach ($requiredKeys as $key) {
    foreach (['en', 'es', 'fr', 'ru', 'sv'] as $lang) {
        $check = $conn->query("SELECT COUNT(*) as count FROM translations WHERE translation_key = '$key' AND lang_code = '$lang'");
        $row = $check->fetch_assoc();
        if ($row['count'] == 0) {
            $missing[] = "$key ($lang)";
        }
    }
}

if (empty($missing)) {
    echo "<div class='success'>✅ Todas las traducciones requeridas están presentes</div>";
} else {
    echo "<div class='error'>❌ Faltan traducciones:</div><ul>";
    foreach ($missing as $miss) {
        echo "<li>$miss</li>";
    }
    echo "</ul>";
}
echo "</div>";

// 7. Links de prueba
echo "<div class='test-section'>";
echo "<h2>7. Links de Prueba</h2>";
echo "<p>Prueba cambiar de idioma en estas páginas:</p>";
echo "<ul>";
echo "<li><a href='index.php?lang=en'>index.php?lang=en</a> (English)</li>";
echo "<li><a href='index.php?lang=es'>index.php?lang=es</a> (Español)</li>";
echo "<li><a href='index.php?lang=fr'>index.php?lang=fr</a> (Français)</li>";
echo "<li><a href='index.php?lang=ru'>index.php?lang=ru</a> (Русский)</li>";
echo "<li><a href='index.php?lang=sv'>index.php?lang=sv</a> (Svenska)</li>";
echo "</ul>";
echo "<ul>";
echo "<li><a href='comprar.php?lang=en'>comprar.php?lang=en</a> (English)</li>";
echo "<li><a href='comprar.php?lang=es'>comprar.php?lang=es</a> (Español)</li>";
echo "</ul>";
echo "</div>";

echo "<hr>";
echo "<h2>✅ Test Completado</h2>";
echo "<p><a href='index.php'>← Volver a la página principal</a></p>";
echo "</body></html>";
?>

