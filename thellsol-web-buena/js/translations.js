// Objeto para almacenar las traducciones
let translations = {};

// Función para cargar las traducciones
async function loadTranslations(lang) {
    try {
        console.log('Cargando traducciones para:', lang);
        const response = await fetch(`./js/lang/${lang}.json`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        translations = await response.json();
        console.log('Traducciones cargadas:', translations);
        updateTranslations();
    } catch (error) {
        console.error('Error al cargar las traducciones:', error);
    }
}

// Función para actualizar las traducciones en la página
function updateTranslations() {
    console.log('Actualizando traducciones...');
    document.querySelectorAll('[data-translate]').forEach(element => {
        const key = element.getAttribute('data-translate');
        console.log('Traduciendo elemento:', key);
        
        const keys = key.split('.');
        let value = translations;
        
        for (const k of keys) {
            if (value && value[k]) {
                value = value[k];
            } else {
                console.log(`No se encontró traducción para: ${key}`);
                return; // No actualizar si no se encuentra la traducción
            }
        }
        
        if (typeof value === 'string') {
            element.textContent = value;
            console.log(`Traducción aplicada: ${key} -> ${value}`);
        }
    });
}

// Inicializar las traducciones cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM cargado, inicializando traducciones...');
    const savedLang = localStorage.getItem('selectedLanguage') || 'es';
    loadTranslations(savedLang);
}); 