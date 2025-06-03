// Definir los idiomas disponibles
const languages = {
    'es': { name: 'Español' },
    'en': { name: 'English' },
    'fr': { name: 'Français' },
    'de': { name: 'Deutsch' }
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
    event.preventDefault();
    const flag = event.currentTarget;
    const lang = flag.getAttribute('data-lang');
    console.log('Bandera clickeada:', lang);
    
    if (lang) {
        changeLanguage(lang);
    }
}

// Función para cambiar el idioma
function changeLanguage(lang) {
    console.log('Cambiando idioma a:', lang);
    localStorage.setItem('selectedLanguage', lang);
    loadTranslations(lang);
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', initLanguageSelector); 