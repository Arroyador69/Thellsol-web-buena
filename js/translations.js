class TranslationManager {
    constructor() {
        this.currentLang = 'es';
        this.translations = {};
        this.loadedLanguages = new Set();
    }

    async init() {
        // Cargar el idioma por defecto (español)
        await this.loadLanguage('es');
        
        // Cargar el idioma guardado en localStorage si existe
        const savedLang = localStorage.getItem('preferredLanguage');
        if (savedLang && savedLang !== 'es') {
            await this.changeLanguage(savedLang);
        }
    }

    async loadLanguage(lang) {
        if (this.loadedLanguages.has(lang)) return;

        try {
            const response = await fetch(`/js/translations/${lang}.json`);
            if (!response.ok) throw new Error(`No se pudo cargar el idioma ${lang}`);
            
            this.translations[lang] = await response.json();
            this.loadedLanguages.add(lang);
        } catch (error) {
            console.error(`Error cargando el idioma ${lang}:`, error);
            // Si falla la carga, usar español como fallback
            if (lang !== 'es') {
                this.translations[lang] = this.translations['es'];
            }
        }
    }

    async changeLanguage(lang) {
        await this.loadLanguage(lang);
        this.currentLang = lang;
        localStorage.setItem('preferredLanguage', lang);
        this.updatePageContent();
    }

    translate(key) {
        const keys = key.split('.');
        let translation = this.translations[this.currentLang];
        
        for (const k of keys) {
            if (!translation || !translation[k]) {
                console.warn(`Traducción no encontrada para: ${key}`);
                return key;
            }
            translation = translation[k];
        }
        
        return translation;
    }

    updatePageContent() {
        // Actualizar todos los elementos con el atributo data-translate
        document.querySelectorAll('[data-translate]').forEach(element => {
            const key = element.getAttribute('data-translate');
            element.textContent = this.translate(key);
        });

        // Actualizar placeholders
        document.querySelectorAll('[data-translate-placeholder]').forEach(element => {
            const key = element.getAttribute('data-translate-placeholder');
            element.placeholder = this.translate(key);
        });

        // Actualizar títulos
        document.querySelectorAll('[data-translate-title]').forEach(element => {
            const key = element.getAttribute('data-translate-title');
            element.title = this.translate(key);
        });
    }
}

// Crear instancia global
window.translationManager = new TranslationManager();

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    window.translationManager.init();
}); 