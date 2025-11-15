<?php
// Componente selector de idiomas con DROPDOWN
// Incluir este archivo en todas las páginas
// IMPORTANTE: translations.php debe estar incluido antes de este archivo

if (!function_exists('getCurrentLanguage')) {
    require_once 'translations.php';
}

$currentLang = isset($currentLang) ? $currentLang : getCurrentLanguage();

$currentUrl = strtok($_SERVER["REQUEST_URI"], '?');
if (empty($currentUrl) || $currentUrl === '/') {
    $currentUrl = 'index.php';
}

$separator = strpos($currentUrl, '?') !== false ? '&' : '?';
$langChangeUrls = [];
foreach ($languages as $langCode => $langInfo) {
    $langChangeUrls[$langCode] = $currentUrl . $separator . 'lang=' . $langCode;
}

$languageSelectorId = isset($languageSelectorId) ? $languageSelectorId : ('languageSelector_' . uniqid());
$languageSelectorClass = isset($languageSelectorClass) ? $languageSelectorClass : '';

if (!defined('LANGUAGE_SELECTOR_STYLES')) {
    define('LANGUAGE_SELECTOR_STYLES', true);
    ?>
    <style>
    .language-selector {
        position: relative;
        display: inline-flex;
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
        background: transparent;
        border: none;
        color: inherit;
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
    
    .language-selector-mobile {
        width: 100%;
        justify-content: flex-end;
        margin: 0 0 15px 0;
    }
    
    .language-selector-mobile .language-dropdown {
        right: 0;
        left: auto;
    }
    
    .language-selector-mobile .language-current {
        background: rgba(255,255,255,0.1);
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
        .language-selector-mobile {
            justify-content: flex-start;
        }
    }
    </style>
    <?php
}
?>

<div class="language-selector <?php echo htmlspecialchars($languageSelectorClass); ?>" id="<?php echo $languageSelectorId; ?>">
    <button type="button" class="language-current" aria-haspopup="true" aria-expanded="false">
        <span class="language-current-flag"><?php echo $languages[$currentLang]['flag']; ?></span>
        <span style="font-size: 12px; opacity: 0.8;">▼</span>
    </button>
    <div class="language-dropdown">
        <?php foreach ($languages as $langCode => $langInfo): ?>
            <a href="<?php echo $langChangeUrls[$langCode]; ?>" 
               class="language-option <?php echo $currentLang === $langCode ? 'active' : ''; ?>"
               data-lang="<?php echo $langCode; ?>">
                <span class="language-option-flag"><?php echo $langInfo['flag']; ?></span>
                <span class="language-option-name"><?php echo htmlspecialchars($langInfo['name']); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<script>
(function() {
    const selectorId = '<?php echo $languageSelectorId; ?>';
    const selector = document.getElementById(selectorId);
    if (!selector) return;
    const toggle = selector.querySelector('.language-current');
    toggle.addEventListener('click', function(event) {
        event.stopPropagation();
        selector.classList.toggle('active');
    });
    document.addEventListener('click', function(event) {
        if (!selector.contains(event.target)) {
            selector.classList.remove('active');
        }
    });
})();
</script>
<?php
unset($languageSelectorId, $languageSelectorClass);
?>
