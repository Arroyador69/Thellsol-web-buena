const fs = require('fs');
const path = require('path');
const axios = require('axios');

const DEEPL_API_KEY = 'b0b5f90c-91df-417b-91cf-d82690fb09d4:fx';
const LANGUAGES = {
    'en': 'English',
    'fr': 'French',
    'he': 'Hebrew',
    'ru': 'Russian',
    'sv': 'Swedish'
};

async function translateText(text, targetLang) {
    try {
        const response = await axios.post('https://api-free.deepl.com/v2/translate', {
            text: [text],
            target_lang: targetLang
        }, {
            headers: {
                'Authorization': `DeepL-Auth-Key ${DEEPL_API_KEY}`,
                'Content-Type': 'application/json'
            }
        });

        return response.data.translations[0].text;
    } catch (error) {
        console.error(`Error traduciendo a ${targetLang}:`, error);
        return text;
    }
}

async function translateObject(obj, targetLang) {
    const translated = {};
    
    for (const [key, value] of Object.entries(obj)) {
        if (typeof value === 'string') {
            translated[key] = await translateText(value, targetLang);
        } else if (typeof value === 'object' && value !== null) {
            translated[key] = await translateObject(value, targetLang);
        } else {
            translated[key] = value;
        }
    }
    
    return translated;
}

async function generateTranslations() {
    // Leer el archivo de español
    const esTranslations = JSON.parse(
        fs.readFileSync(path.join(__dirname, 'translations', 'es.json'), 'utf8')
    );

    // Generar traducciones para cada idioma
    for (const [langCode, langName] of Object.entries(LANGUAGES)) {
        console.log(`Generando traducciones para ${langName}...`);
        
        const translated = await translateObject(esTranslations, langCode);
        
        // Guardar el archivo de traducción
        fs.writeFileSync(
            path.join(__dirname, 'translations', `${langCode}.json`),
            JSON.stringify(translated, null, 4),
            'utf8'
        );
        
        console.log(`Traducciones para ${langName} completadas.`);
    }
}

// Ejecutar el generador
generateTranslations().catch(console.error); 