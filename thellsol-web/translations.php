<?php
// SISTEMA DE TRADUCCIONES CON MYSQL
// Archivo: translations.php

require_once 'db-config.php';

// Idiomas disponibles
define('AVAILABLE_LANGUAGES', ['en', 'es', 'fr', 'ru', 'sv']);
define('DEFAULT_LANGUAGE', 'en');

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

// Traducciones por defecto en inglés (fallback si no hay BD)
$defaultTranslations = [
    'nav.home' => 'Home',
    'nav.buy' => 'Buy',
    'nav.sell' => 'Sell',
    'nav.legal' => 'Legal Information',
    'nav.contact' => 'Contact',
    'home.welcome' => 'Welcome to TellSol Real Estate',
    'home.intro' => 'We are a real estate company specialized in the Costa del Sol, committed to offering the best service and the best properties to our clients.',
    'home.presentation' => 'With over a decade of experience in the Costa del Sol, I am proud to help you find your ideal home in this wonderful region.',
    'home.presentation2' => 'At TellSol, we don\'t just sell properties; we create lasting relationships based on trust, transparency and commitment to excellence.',
    'home.featured' => 'Featured Properties',
    'home.viewDetails' => 'View Details',
    'home.noProperties' => 'New properties coming soon'
];

// Obtener traducción
function t($key, $default = null) {
    global $defaultTranslations;
    static $translations = [];
    $lang = getCurrentLanguage();
    
    // Cargar traducciones si no están cargadas
    if (!isset($translations[$lang])) {
        $translations[$lang] = loadTranslations($lang);
    }
    
    // Retornar traducción o default
    if (isset($translations[$lang][$key]) && !empty($translations[$lang][$key])) {
        return $translations[$lang][$key];
    }
    
    // Si no existe, intentar con inglés como fallback
    if ($lang !== 'en') {
        if (!isset($translations['en'])) {
            $translations['en'] = loadTranslations('en');
        }
        if (isset($translations['en'][$key]) && !empty($translations['en'][$key])) {
            return $translations['en'][$key];
        }
    }
    
    // Si no hay en BD, usar traducciones por defecto en inglés
    if (isset($defaultTranslations[$key])) {
        return $defaultTranslations[$key];
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
    
    $translations = [];
    
    try {
        $conn = getDBConnection();
        
        // Verificar que la tabla existe primero
        $tableCheck = $conn->query("SHOW TABLES LIKE 'translations'");
        if ($tableCheck->num_rows === 0) {
            // Tabla no existe, retornar array vacío
            $cache[$lang] = [];
            return [];
        }
        
        $stmt = $conn->prepare("SELECT translation_key, translation_value FROM translations WHERE lang_code = ?");
        if ($stmt) {
            $stmt->bind_param("s", $lang);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $translations[$row['translation_key']] = $row['translation_value'];
                }
            }
            $stmt->close();
        }
    } catch (Exception $e) {
        // Si hay error, retornar array vacío (no fallar)
        $translations = [];
    }
    
    // Guardar en cache
    $cache[$lang] = $translations;
    
    return $translations;
}

// Obtener idioma actual
$currentLang = getCurrentLanguage();

// Información de idiomas (inglés primero como default)
$languages = [
    'en' => ['name' => 'English', 'flag' => '🇬🇧', 'code' => 'en'],
    'es' => ['name' => 'Español', 'flag' => '🇪🇸', 'code' => 'es'],
    'fr' => ['name' => 'Français', 'flag' => '🇫🇷', 'code' => 'fr'],
    'ru' => ['name' => 'Русский', 'flag' => '🇷🇺', 'code' => 'ru'],
    'sv' => ['name' => 'Svenska', 'flag' => '🇸🇪', 'code' => 'sv']
];

?>

