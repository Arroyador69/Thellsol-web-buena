class LanguageSelector {
    constructor() {
        this.languages = {
            'es': { name: 'Español', flag: '🇪🇸' },
            'en': { name: 'English', flag: '🇬🇧' },
            'fr': { name: 'Français', flag: '🇫🇷' },
            'he': { name: 'עברית', flag: '🇮🇱' },
            'ru': { name: 'Русский', flag: '🇷🇺' },
            'sv': { name: 'Svenska', flag: '🇸🇪' }
        };
    }

    createSelector() {
        const container = document.createElement('div');
        container.className = 'language-selector';
        
        const currentLang = document.createElement('div');
        currentLang.className = 'current-language';
        const currentLangCode = window.translationManager.currentLang;
        currentLang.innerHTML = `${this.languages[currentLangCode].flag} ${this.languages[currentLangCode].name}`;
        
        const dropdown = document.createElement('div');
        dropdown.className = 'language-dropdown';
        
        Object.entries(this.languages).forEach(([code, lang]) => {
            if (code !== currentLangCode) {
                const option = document.createElement('div');
                option.className = 'language-option';
                option.innerHTML = `${lang.flag} ${lang.name}`;
                option.onclick = () => this.changeLanguage(code);
                dropdown.appendChild(option);
            }
        });
        
        container.appendChild(currentLang);
        container.appendChild(dropdown);
        
        // Toggle dropdown
        currentLang.onclick = () => {
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        };
        
        // Cerrar dropdown al hacer clic fuera
        document.addEventListener('click', (e) => {
            if (!container.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
        
        return container;
    }

    async changeLanguage(langCode) {
        await window.translationManager.changeLanguage(langCode);
        this.updateSelector();
    }

    updateSelector() {
        const currentLang = document.querySelector('.current-language');
        const currentLangCode = window.translationManager.currentLang;
        currentLang.innerHTML = `${this.languages[currentLangCode].flag} ${this.languages[currentLangCode].name}`;
    }
}

// Añadir estilos
const style = document.createElement('style');
style.textContent = `
    .language-selector {
        position: relative;
        display: inline-block;
        margin-left: 20px;
    }

    .current-language {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: #fff;
        border-radius: 4px;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .language-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin-top: 4px;
        z-index: 1000;
    }

    .language-option {
        padding: 8px 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .language-option:hover {
        background: #f5f5f5;
    }
`;
document.head.appendChild(style);

// Inicializar el selector cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    const selector = new LanguageSelector();
    const header = document.querySelector('header');
    if (header) {
        header.appendChild(selector.createSelector());
    }
}); 