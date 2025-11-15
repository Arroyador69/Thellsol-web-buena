<?php
// Componente selector de idiomas
// Incluir este archivo en todas las páginas

require_once 'translations.php';

// Obtener URL actual sin parámetros de idioma
$currentUrl = strtok($_SERVER["REQUEST_URI"], '?');
if (empty($currentUrl) || $currentUrl === '/') {
    $currentUrl = 'index.php';
}

// Función para generar URL con cambio de idioma
function getLangUrl($lang) {
    global $currentUrl;
    $separator = strpos($currentUrl, '?') !== false ? '&' : '?';
    return $currentUrl . $separator . 'lang=' . $lang;
}
?>

<style>
.language-selector {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-left: 10px;
}

.language-flag {
    font-size: 20px;
    cursor: pointer;
    padding: 4px 6px;
    border-radius: 4px;
    transition: background 0.2s;
    opacity: 0.7;
    text-decoration: none;
    display: inline-block;
}

.language-flag:hover {
    opacity: 1;
    background: rgba(255, 255, 255, 0.1);
}

.language-flag.active {
    opacity: 1;
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

@media (max-width: 768px) {
    .language-selector {
        gap: 4px;
        margin-left: 5px;
    }
    .language-flag {
        font-size: 18px;
        padding: 3px 4px;
    }
}
</style>

<div class="language-selector">
    <?php foreach ($languages as $langCode => $langInfo): ?>
        <a href="<?php echo getLangUrl($langCode); ?>" 
           class="language-flag <?php echo $currentLang === $langCode ? 'active' : ''; ?>" 
           title="<?php echo htmlspecialchars($langInfo['name']); ?>"
           data-lang="<?php echo $langCode; ?>">
            <?php echo $langInfo['flag']; ?>
        </a>
    <?php endforeach; ?>
</div>

