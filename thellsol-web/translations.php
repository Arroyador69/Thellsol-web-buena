<?php
// SISTEMA DE TRADUCCIONES CON MYSQL
// Archivo: translations.php

require_once 'db-config.php';

// Idiomas disponibles
define('AVAILABLE_LANGUAGES', ['es', 'en', 'fr', 'ru', 'sv']);
define('DEFAULT_LANGUAGE', 'es');

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener idioma actual
function getCurrentLanguage() {
    // 1. Verificar si hay cambio de idioma en GET
    if (isset($_GET['lang']) && in_array($_GET['lang'], AVAILABLE_LANGUAGES)) {
        $_SESSION['lang'] = $_GET['lang'];
        setcookie('lang', $_GET['lang'], time() + (365 * 24 * 60 * 60), '/'); // Cookie por 1 año
        return $_GET['lang'];
    }
    
    // 2. Verificar sesión
    if (isset($_SESSION['lang']) && in_array($_SESSION['lang'], AVAILABLE_LANGUAGES)) {
        return $_SESSION['lang'];
    }
    
    // 3. Verificar cookie
    if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], AVAILABLE_LANGUAGES)) {
        $_SESSION['lang'] = $_COOKIE['lang'];
        return $_COOKIE['lang'];
    }
    
    // 4. Detectar idioma del navegador
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if (in_array($browserLang, AVAILABLE_LANGUAGES)) {
            $_SESSION['lang'] = $browserLang;
            return $browserLang;
        }
    }
    
    // 5. Idioma por defecto
    $_SESSION['lang'] = DEFAULT_LANGUAGE;
    return DEFAULT_LANGUAGE;
}

// Obtener traducción
function t($key, $default = null) {
    static $translations = [];
    $lang = getCurrentLanguage();
    
    // Cargar traducciones si no están cargadas
    if (!isset($translations[$lang])) {
        $translations[$lang] = loadTranslations($lang);
    }
    
    // Retornar traducción o default
    if (isset($translations[$lang][$key])) {
        return $translations[$lang][$key];
    }
    
    // Si no existe, intentar con español como fallback
    if ($lang !== 'es') {
        if (!isset($translations['es'])) {
            $translations['es'] = loadTranslations('es');
        }
        if (isset($translations['es'][$key])) {
            return $translations['es'][$key];
        }
    }
    
    // Retornar default o la key
    return $default !== null ? $default : $key;
}

// Cargar traducciones desde MySQL
function loadTranslations($lang) {
    static $cache = [];
    
    // Usar cache si existe
    if (isset($cache[$lang])) {
        return $cache[$lang];
    }
    
    $conn = getDBConnection();
    $translations = [];
    
    $stmt = $conn->prepare("SELECT translation_key, translation_value FROM translations WHERE lang_code = ?");
    $stmt->bind_param("s", $lang);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $translations[$row['translation_key']] = $row['translation_value'];
    }
    
    $stmt->close();
    
    // Guardar en cache
    $cache[$lang] = $translations;
    
    return $translations;
}

// Obtener idioma actual
$currentLang = getCurrentLanguage();

// Información de idiomas
$languages = [
    'es' => ['name' => 'Español', 'flag' => '🇪🇸', 'code' => 'es'],
    'en' => ['name' => 'English', 'flag' => '🇬🇧', 'code' => 'en'],
    'fr' => ['name' => 'Français', 'flag' => '🇫🇷', 'code' => 'fr'],
    'ru' => ['name' => 'Русский', 'flag' => '🇷🇺', 'code' => 'ru'],
    'sv' => ['name' => 'Svenska', 'flag' => '🇸🇪', 'code' => 'sv']
];

?>

