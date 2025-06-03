// Definir los idiomas disponibles
const languages = {
    'es': { name: 'Español' },
    'en': { name: 'English' },
    'fr': { name: 'Français' },
    'de': { name: 'Deutsch' },
    'ru': { name: 'Русский' },
    'sv': { name: 'Svenska' },
    'he': { name: 'עברית' }
};

// Función para inicializar el selector de idiomas
function initLanguageSelector() {
    console.log('Inicializando selector de idiomas...');

    // Añadir event listeners a todas las banderas
    document.querySelectorAll('.language-flag').forEach(flag => {
        console.log('Añadiendo evento a bandera:', flag.getAttribute('data-lang'));
        
        // Remover eventos anteriores para evitar duplicados
        flag.removeEventListener('click', handleFlagClick);
        
        // Añadir el nuevo evento
        flag.addEventListener('click', handleFlagClick);
    });

    // Cargar el idioma guardado o usar español por defecto
    const savedLang = localStorage.getItem('selectedLanguage') || 'es';
    console.log('Idioma guardado:', savedLang);
    loadTranslations(savedLang);
}

// Función para manejar el clic en una bandera
function handleFlagClick(event) {
    const lang = event.currentTarget.getAttribute('data-lang');
    console.log('Bandera clickeada:', lang);
    changeLanguage(lang);
}

// Función para cambiar el idioma
function changeLanguage(lang) {
    console.log('Cambiando idioma a:', lang);
    localStorage.setItem('selectedLanguage', lang);
    loadTranslations(lang);
    
    // Actualizar el texto del botón de idioma
    const langName = languages[lang].name;
    const langFlag = `fi fi-${lang === 'he' ? 'il' : lang}`;
    
    // Actualizar en el menú de escritorio
    const desktopButton = document.querySelector('.language-dropdown-desktop .navbar-link');
    if (desktopButton) {
        desktopButton.innerHTML = `<span class="${langFlag}"></span> ${langName} <span style="font-size:12px;">▼</span>`;
    }
    
    // Actualizar en el menú móvil
    const mobileButton = document.querySelector('.language-dropdown-mobile .navbar-link');
    if (mobileButton) {
        mobileButton.innerHTML = `<span class="${langFlag}"></span> ${langName} <span style="font-size:12px;">▼</span>`;
    }
}

// Función para cargar las traducciones
async function loadTranslations(lang) {
    try {
        const response = await fetch(`./js/lang/${lang}.json`);
        const translations = await response.json();
        
        // Actualizar todos los elementos con data-translate
        document.querySelectorAll('[data-translate]').forEach(element => {
            const key = element.getAttribute('data-translate');
            const keys = key.split('.');
            let value = translations;
            
            for (const k of keys) {
                if (value && value[k]) {
                    value = value[k];
                } else {
                    value = key;
                    break;
                }
            }
            
            if (typeof value === 'string') {
                element.textContent = value;
            }
        });
        
        // Actualizar el título de la página si existe
        const titleKey = 'nav.home';
        const titleKeys = titleKey.split('.');
        let titleValue = translations;
        
        for (const k of titleKeys) {
            if (titleValue && titleValue[k]) {
                titleValue = titleValue[k];
            } else {
                titleValue = 'ThellSol Real Estate';
                break;
            }
        }
        
        document.title = `${titleValue} | ThellSol Real Estate`;
        
    } catch (error) {
        console.error('Error cargando traducciones:', error);
    }
}

// Exponer la función globalmente para poder llamarla tras cargar el menú dinámicamente
window.initLanguageSelector = initLanguageSelector;

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', initLanguageSelector); 