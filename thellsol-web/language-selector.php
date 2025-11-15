<?php
// Componente selector de idiomas con DROPDOWN
// Incluir este archivo en todas las páginas
// IMPORTANTE: translations.php debe estar incluido antes de este archivo

// Verificar que translations.php está cargado
if (!function_exists('getCurrentLanguage')) {
    require_once 'translations.php';
}

// Obtener idioma actual
$currentLang = isset($currentLang) ? $currentLang : getCurrentLanguage();

// Obtener URL actual sin parámetros de idioma
$currentUrl = strtok($_SERVER["REQUEST_URI"], '?');
if (empty($currentUrl) || $currentUrl === '/') {
    $currentUrl = 'index.php';
}

// Función para generar URL con cambio de idioma (local para este componente)
function getLangChangeUrl($lang) {
    global $currentUrl;
    $separator = strpos($currentUrl, '?') !== false ? '&' : '?';
    return $currentUrl . $separator . 'lang=' . $lang;
}
?>

<style>
.language-selector {
    position: relative;
    display: inline-block;
    margin-left: 10px;
}

.language-current {
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    padding: 6px 10px;
    border-radius: 4px;
    transition: background 0.2s;
    font-size: 20px;
    user-select: none;
}

.language-current:hover {
    background: rgba(255, 255, 255, 0.1);
}

.language-current-flag {
    font-size: 20px;
}

.language-dropdown {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    background: #181e29;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    margin-top: 5px;
    min-width: 150px;
    z-index: 1000;
    overflow: hidden;
}

.language-selector.active .language-dropdown {
    display: block;
}

.language-option {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 15px;
    color: #fff;
    text-decoration: none;
    transition: background 0.2s;
    font-size: 14px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.language-option:last-child {
    border-bottom: none;
}

.language-option:hover {
    background: rgba(255, 255, 255, 0.1);
}

.language-option.active {
    background: rgba(255, 255, 255, 0.15);
    font-weight: 600;
}

.language-option-flag {
    font-size: 18px;
}

.language-option-name {
    flex: 1;
}

@media (max-width: 768px) {
    .language-selector {
        margin-left: 5px;
    }
    .language-current {
        padding: 4px 8px;
        font-size: 18px;
    }
    .language-dropdown {
        right: 0;
        min-width: 140px;
    }
}
</style>

<div class="language-selector" id="languageSelector">
    <div class="language-current" onclick="toggleLanguageDropdown()">
        <span class="language-current-flag"><?php echo $languages[$currentLang]['flag']; ?></span>
        <span style="font-size: 12px; opacity: 0.8;">▼</span>
    </div>
    <div class="language-dropdown">
        <?php foreach ($languages as $langCode => $langInfo): ?>
            <a href="<?php echo getLangChangeUrl($langCode); ?>" 
               class="language-option <?php echo $currentLang === $langCode ? 'active' : ''; ?>"
               data-lang="<?php echo $langCode; ?>">
                <span class="language-option-flag"><?php echo $langInfo['flag']; ?></span>
                <span class="language-option-name"><?php echo htmlspecialchars($langInfo['name']); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<script>
function toggleLanguageDropdown() {
    const selector = document.getElementById('languageSelector');
    selector.classList.toggle('active');
}

// Cerrar dropdown al hacer clic fuera
document.addEventListener('click', function(event) {
    const selector = document.getElementById('languageSelector');
    if (!selector.contains(event.target)) {
        selector.classList.remove('active');
    }
});
</script>
