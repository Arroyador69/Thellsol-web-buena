// Este archivo es una versión compilada de generate-daily-post.ts
// Se ejecuta con Node.js para generar posts diariamente

const { generateBlogPost } = require('../dist/lib/blog');
const { savePost } = require('../dist/lib/blog/posts');

// Temas predefinidos para el blog (solo ciudades de la Costa del Sol)
const TOPICS = [
  { topic: 'Inversión inmobiliaria', city: 'Marbella' },
  { topic: 'Comprar casa', city: 'Málaga' },
  { topic: 'Alquiler de viviendas', city: 'Fuengirola' },
  { topic: 'Mercado inmobiliario', city: 'Benalmádena' },
  { topic: 'Hipotecas', city: 'Mijas' },
  { topic: 'Reforma de viviendas', city: 'La Cala de Mijas' },
  { topic: 'Tendencias inmobiliarias', city: 'Marbella' },
  { topic: 'Fiscalidad inmobiliaria', city: 'Málaga' },
  { topic: 'Comunidades de vecinos', city: 'Fuengirola' },
  { topic: 'Decoración de interiores', city: 'Benalmádena' },
  { topic: 'Smart homes', city: 'Mijas' },
  { topic: 'Sostenibilidad en viviendas', city: 'La Cala de Mijas' },
  { topic: 'Mercado de lujo', city: 'Marbella' },
  { topic: 'Inversión en locales', city: 'Málaga' },
  { topic: 'Vivienda vacacional', city: 'Fuengirola' },
  { topic: 'Comprar terreno', city: 'Benalmádena' },
  { topic: 'Revalorización inmobiliaria', city: 'Mijas' },
  { topic: 'Vivienda social', city: 'La Cala de Mijas' },
  { topic: 'Mercado de oficinas', city: 'Marbella' },
  { topic: 'Inversión en garajes', city: 'Málaga' },
  { topic: 'Vivienda unifamiliar', city: 'Fuengirola' },
  { topic: 'Mercado de alquiler', city: 'Benalmádena' },
  { topic: 'Comprar piso', city: 'Mijas' },
  { topic: 'Inversión en naves', city: 'La Cala de Mijas' },
  { topic: 'Vivienda de obra nueva', city: 'Marbella' },
  { topic: 'Mercado de segunda mano', city: 'Málaga' },
  { topic: 'Inversión en hoteles', city: 'Fuengirola' },
  { topic: 'Vivienda de protección oficial', city: 'Benalmádena' },
  { topic: 'Mercado de locales comerciales', city: 'Mijas' },
  { topic: 'Inversión en terrenos', city: 'La Cala de Mijas' },
  { topic: 'Vivienda de lujo', city: 'Marbella' }
];

async function generateDailyPost() {
  try {
    // Seleccionar un tema aleatorio
    const randomIndex = Math.floor(Math.random() * TOPICS.length);
    const { topic, city } = TOPICS[randomIndex];
    
    console.log(`Generando artículo sobre "${topic}" en ${city}...`);
    
    // Generar el artículo
    const post = await generateBlogPost(topic, city);
    
    // Asegurarse de que el contenido tenga entre 300 y 800 palabras
    const wordCount = post.content.split(/\s+/).length;
    if (wordCount < 300 || wordCount > 800) {
      console.log(`El artículo tiene ${wordCount} palabras, regenerando...`);
      return generateDailyPost(); // Recursivamente intentar de nuevo
    }
    
    // Guardar el artículo
    await savePost(post);
    
    console.log(`Artículo generado y guardado: ${post.title}`);
    return post;
  } catch (error) {
    console.error('Error generando el artículo diario:', error);
    throw error;
  }
}

// Ejecutar la función
generateDailyPost()
  .then(() => process.exit(0))
  .catch(error => {
    console.error(error);
    process.exit(1);
  }); 