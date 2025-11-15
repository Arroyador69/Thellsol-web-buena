<?php
// Script para insertar traducciones directamente en MySQL
// Ejecutar una vez: https://thellsol.com/insert-translations-direct.php

require_once 'db-config.php';

$conn = getDBConnection();

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Insert Translations</title>";
echo "<style>body{font-family:Arial;max-width:900px;margin:50px auto;padding:20px;}";
echo ".success{background:#d4edda;color:#155724;padding:10px;border-radius:5px;margin:5px 0;}";
echo ".error{background:#f8d7da;color:#721c24;padding:10px;border-radius:5px;margin:5px 0;}";
echo ".info{background:#d1ecf1;color:#0c5460;padding:10px;border-radius:5px;margin:5px 0;}";
echo "</style></head><body>";
echo "<h1>🌍 Insertando Traducciones</h1>";

// Array con todas las traducciones
$translations = [
    // NAVEGACIÓN
    ['es', 'nav.home', 'Inicio'],
    ['en', 'nav.home', 'Home'],
    ['fr', 'nav.home', 'Accueil'],
    ['ru', 'nav.home', 'Главная'],
    ['sv', 'nav.home', 'Hem'],
    
    ['es', 'nav.buy', 'Comprar'],
    ['en', 'nav.buy', 'Buy'],
    ['fr', 'nav.buy', 'Acheter'],
    ['ru', 'nav.buy', 'Купить'],
    ['sv', 'nav.buy', 'Köp'],
    
    ['es', 'nav.sell', 'Vender'],
    ['en', 'nav.sell', 'Sell'],
    ['fr', 'nav.sell', 'Vendre'],
    ['ru', 'nav.sell', 'Продать'],
    ['sv', 'nav.sell', 'Sälj'],
    
    ['es', 'nav.legal', 'Información Legal'],
    ['en', 'nav.legal', 'Legal Information'],
    ['fr', 'nav.legal', 'Informations Légales'],
    ['ru', 'nav.legal', 'Юридическая Информация'],
    ['sv', 'nav.legal', 'Juridisk Information'],
    
    ['es', 'nav.contact', 'Contacto'],
    ['en', 'nav.contact', 'Contact'],
    ['fr', 'nav.contact', 'Contact'],
    ['ru', 'nav.contact', 'Контакты'],
    ['sv', 'nav.contact', 'Kontakt'],
    
    // PÁGINA INICIO
    ['es', 'home.welcome', 'Bienvenido a TellSol Real Estate'],
    ['en', 'home.welcome', 'Welcome to TellSol Real Estate'],
    ['fr', 'home.welcome', 'Bienvenue chez TellSol Real Estate'],
    ['ru', 'home.welcome', 'Добро пожаловать в TellSol Real Estate'],
    ['sv', 'home.welcome', 'Välkommen till TellSol Real Estate'],
    
    ['es', 'home.intro', 'Somos una empresa inmobiliaria especializada en la Costa del Sol, comprometida con ofrecer el mejor servicio y las mejores propiedades a nuestros clientes.'],
    ['en', 'home.intro', 'We are a real estate company specialized in the Costa del Sol, committed to offering the best service and the best properties to our clients.'],
    ['fr', 'home.intro', 'Nous sommes une entreprise immobilière spécialisée dans la Costa del Sol, engagée à offrir le meilleur service et les meilleures propriétés à nos clients.'],
    ['ru', 'home.intro', 'Мы - агентство недвижимости, специализирующееся на Коста-дель-Соль, стремящееся предложить лучший сервис и лучшую недвижимость нашим клиентам.'],
    ['sv', 'home.intro', 'Vi är ett fastighetsföretag specialiserat på Costa del Sol, engagerade i att erbjuda den bästa servicen och de bästa fastigheterna till våra kunder.'],
    
    ['es', 'home.presentation', 'Con más de una década de experiencia en la Costa del Sol, me enorgullece poder ayudarte a encontrar tu hogar ideal en esta maravillosa región.'],
    ['en', 'home.presentation', 'With over a decade of experience in the Costa del Sol, I am proud to help you find your ideal home in this wonderful region.'],
    ['fr', 'home.presentation', 'Avec plus d\'une décennie d\'expérience dans la Costa del Sol, je suis fier de pouvoir vous aider à trouver votre maison idéale dans cette merveilleuse région.'],
    ['ru', 'home.presentation', 'Имея более десяти лет опыта на Коста-дель-Соль, я горжусь возможностью помочь вам найти идеальный дом в этом прекрасном регионе.'],
    ['sv', 'home.presentation', 'Med över ett decennium av erfarenhet på Costa del Sol är jag stolt över att kunna hjälpa dig att hitta ditt ideala hem i denna underbara region.'],
    
    ['es', 'home.presentation2', 'En TellSol, no solo vendemos propiedades; creamos relaciones duraderas basadas en la confianza, la transparencia y el compromiso con la excelencia.'],
    ['en', 'home.presentation2', 'At TellSol, we don\'t just sell properties; we create lasting relationships based on trust, transparency and commitment to excellence.'],
    ['fr', 'home.presentation2', 'Chez TellSol, nous ne vendons pas seulement des propriétés; nous créons des relations durables basées sur la confiance, la transparence et l\'engagement envers l\'excellence.'],
    ['ru', 'home.presentation2', 'В TellSol мы не просто продаем недвижимость; мы создаем долгосрочные отношения, основанные на доверии, прозрачности и приверженности совершенству.'],
    ['sv', 'home.presentation2', 'På TellSol säljer vi inte bara fastigheter; vi skapar varaktiga relationer baserade på förtroende, transparens och engagemang för excellens.'],
    
    ['es', 'home.featured', 'Propiedades Destacadas'],
    ['en', 'home.featured', 'Featured Properties'],
    ['fr', 'home.featured', 'Propriétés en Vedette'],
    ['ru', 'home.featured', 'Рекомендуемые Объекты'],
    ['sv', 'home.featured', 'Utvalda Fastigheter'],
    
    ['es', 'home.viewDetails', 'Ver Detalles'],
    ['en', 'home.viewDetails', 'View Details'],
    ['fr', 'home.viewDetails', 'Voir les Détails'],
    ['ru', 'home.viewDetails', 'Подробнее'],
    ['sv', 'home.viewDetails', 'Visa Detaljer'],
    
    ['es', 'home.noProperties', 'Próximamente nuevas propiedades'],
    ['en', 'home.noProperties', 'New properties coming soon'],
    ['fr', 'home.noProperties', 'Nouvelles propriétés à venir'],
    ['ru', 'home.noProperties', 'Скоро новые объекты'],
    ['sv', 'home.noProperties', 'Nya fastigheter kommer snart'],
    
    // PÁGINA COMPRAR
    ['es', 'buy.title', 'Comprar Propiedades'],
    ['en', 'buy.title', 'Buy Properties'],
    ['fr', 'buy.title', 'Acheter des Propriétés'],
    ['ru', 'buy.title', 'Купить Недвижимость'],
    ['sv', 'buy.title', 'Köp Fastigheter'],
    
    ['es', 'buy.filter', 'Filtrar Propiedades'],
    ['en', 'buy.filter', 'Filter Properties'],
    ['fr', 'buy.filter', 'Filtrer les Propriétés'],
    ['ru', 'buy.filter', 'Фильтр Объектов'],
    ['sv', 'buy.filter', 'Filtrera Fastigheter'],
    
    ['es', 'buy.location', 'Ubicación'],
    ['en', 'buy.location', 'Location'],
    ['fr', 'buy.location', 'Emplacement'],
    ['ru', 'buy.location', 'Местоположение'],
    ['sv', 'buy.location', 'Plats'],
    
    ['es', 'buy.type', 'Tipo'],
    ['en', 'buy.type', 'Type'],
    ['fr', 'buy.type', 'Type'],
    ['ru', 'buy.type', 'Тип'],
    ['sv', 'buy.type', 'Typ'],
    
    ['es', 'buy.price', 'Precio'],
    ['en', 'buy.price', 'Price'],
    ['fr', 'buy.price', 'Prix'],
    ['ru', 'buy.price', 'Цена'],
    ['sv', 'buy.price', 'Pris'],
    
    ['es', 'buy.bedrooms', 'Dormitorios'],
    ['en', 'buy.bedrooms', 'Bedrooms'],
    ['fr', 'buy.bedrooms', 'Chambres'],
    ['ru', 'buy.bedrooms', 'Спальни'],
    ['sv', 'buy.bedrooms', 'Sovrum'],
    
    ['es', 'buy.bathrooms', 'Baños'],
    ['en', 'buy.bathrooms', 'Bathrooms'],
    ['fr', 'buy.bathrooms', 'Salles de Bain'],
    ['ru', 'buy.bathrooms', 'Ванные'],
    ['sv', 'buy.bathrooms', 'Badrum'],
    
    ['es', 'buy.area', 'Superficie'],
    ['en', 'buy.area', 'Area'],
    ['fr', 'buy.area', 'Superficie'],
    ['ru', 'buy.area', 'Площадь'],
    ['sv', 'buy.area', 'Yta'],
    
    // PÁGINA VENDER
    ['es', 'sell.title', 'Vender tu Propiedad con ThellSol'],
    ['en', 'sell.title', 'Sell your Property with ThellSol'],
    ['fr', 'sell.title', 'Vendez votre Propriété avec ThellSol'],
    ['ru', 'sell.title', 'Продайте свою Недвижимость с ThellSol'],
    ['sv', 'sell.title', 'Sälj din Fastighet med ThellSol'],
    
    ['es', 'sell.subtitle', 'Proceso seguro, rápido y sin complicaciones'],
    ['en', 'sell.subtitle', 'Secure, fast and uncomplicated process'],
    ['fr', 'sell.subtitle', 'Processus sûr, rapide et sans complications'],
    ['ru', 'sell.subtitle', 'Безопасный, быстрый и простой процесс'],
    ['sv', 'sell.subtitle', 'Säker, snabb och okomplicerad process'],
    
    ['es', 'sell.description', 'En ThellSol Real Estate, entendemos que vender una propiedad puede ser un proceso complejo. Por eso, ofrecemos un servicio completo y profesional que te acompañará en cada paso del camino.'],
    ['en', 'sell.description', 'At ThellSol Real Estate, we understand that selling a property can be a complex process. That\'s why we offer a complete and professional service that will accompany you every step of the way.'],
    ['fr', 'sell.description', 'Chez ThellSol Real Estate, nous comprenons que vendre une propriété peut être un processus complexe. C\'est pourquoi nous offrons un service complet et professionnel qui vous accompagnera à chaque étape.'],
    ['ru', 'sell.description', 'В ThellSol Real Estate мы понимаем, что продажа недвижимости может быть сложным процессом. Поэтому мы предлагаем полный и профессиональный сервис, который будет сопровождать вас на каждом этапе.'],
    ['sv', 'sell.description', 'På ThellSol Real Estate förstår vi att sälja en fastighet kan vara en komplex process. Därför erbjuder vi en komplett och professionell service som kommer att följa dig varje steg på vägen.'],
    
    // PÁGINA CONTACTO
    ['es', 'contact.title', 'Contacto'],
    ['en', 'contact.title', 'Contact'],
    ['fr', 'contact.title', 'Contact'],
    ['ru', 'contact.title', 'Контакты'],
    ['sv', 'contact.title', 'Kontakt'],
    
    ['es', 'contact.name', 'Nombre'],
    ['en', 'contact.name', 'Name'],
    ['fr', 'contact.name', 'Nom'],
    ['ru', 'contact.name', 'Имя'],
    ['sv', 'contact.name', 'Namn'],
    
    ['es', 'contact.email', 'Email'],
    ['en', 'contact.email', 'Email'],
    ['fr', 'contact.email', 'Email'],
    ['ru', 'contact.email', 'Email'],
    ['sv', 'contact.email', 'E-post'],
    
    ['es', 'contact.message', 'Mensaje'],
    ['en', 'contact.message', 'Message'],
    ['fr', 'contact.message', 'Message'],
    ['ru', 'contact.message', 'Сообщение'],
    ['sv', 'contact.message', 'Meddelande'],
    
    ['es', 'contact.send', 'Enviar'],
    ['en', 'contact.send', 'Send'],
    ['fr', 'contact.send', 'Envoyer'],
    ['ru', 'contact.send', 'Отправить'],
    ['sv', 'contact.send', 'Skicka'],
    
    // PÁGINA INFORMACIÓN LEGAL
    ['es', 'legal.title', 'Información Legal'],
    ['en', 'legal.title', 'Legal Information'],
    ['fr', 'legal.title', 'Informations Légales'],
    ['ru', 'legal.title', 'Юридическая Информация'],
    ['sv', 'legal.title', 'Juridisk Information'],
    
    ['es', 'legal.privacy', 'Política de Privacidad'],
    ['en', 'legal.privacy', 'Privacy Policy'],
    ['fr', 'legal.privacy', 'Politique de Confidentialité'],
    ['ru', 'legal.privacy', 'Политика Конфиденциальности'],
    ['sv', 'legal.privacy', 'Integritetspolicy'],
    
    ['es', 'legal.cookies', 'Política de Cookies'],
    ['en', 'legal.cookies', 'Cookie Policy'],
    ['fr', 'legal.cookies', 'Politique des Cookies'],
    ['ru', 'legal.cookies', 'Политика Cookie'],
    ['sv', 'legal.cookies', 'Cookiepolicy'],
    
    ['es', 'legal.terms', 'Aviso Legal'],
    ['en', 'legal.terms', 'Legal Notice'],
    ['fr', 'legal.terms', 'Avis Légal'],
    ['ru', 'legal.terms', 'Юридическое Уведомление'],
    ['sv', 'legal.terms', 'Juridiskt Meddelande'],
    
    // FOOTER
    ['es', 'footer.contact', 'Contacto'],
    ['en', 'footer.contact', 'Contact'],
    ['fr', 'footer.contact', 'Contact'],
    ['ru', 'footer.contact', 'Контакты'],
    ['sv', 'footer.contact', 'Kontakt'],
    
    ['es', 'footer.legal', 'Enlaces Legales'],
    ['en', 'footer.legal', 'Legal Links'],
    ['fr', 'footer.legal', 'Liens Légaux'],
    ['ru', 'footer.legal', 'Юридические Ссылки'],
    ['sv', 'footer.legal', 'Juridiska Länkar'],
    
    // PROPIEDADES
    ['es', 'property.bedrooms', 'Dormitorios'],
    ['en', 'property.bedrooms', 'Bedrooms'],
    ['fr', 'property.bedrooms', 'Chambres'],
    ['ru', 'property.bedrooms', 'Спальни'],
    ['sv', 'property.bedrooms', 'Sovrum'],
    
    ['es', 'property.bathrooms', 'Baños'],
    ['en', 'property.bathrooms', 'Bathrooms'],
    ['fr', 'property.bathrooms', 'Salles de Bain'],
    ['ru', 'property.bathrooms', 'Ванные'],
    ['sv', 'property.bathrooms', 'Badrum'],
    
    ['es', 'property.area', 'Superficie'],
    ['en', 'property.area', 'Area'],
    ['fr', 'property.area', 'Superficie'],
    ['ru', 'property.area', 'Площадь'],
    ['sv', 'property.area', 'Yta'],
    
    ['es', 'property.type', 'Tipo'],
    ['en', 'property.type', 'Type'],
    ['fr', 'property.type', 'Type'],
    ['ru', 'property.type', 'Тип'],
    ['sv', 'property.type', 'Typ'],
    
    ['es', 'property.description', 'Descripción'],
    ['en', 'property.description', 'Description'],
    ['fr', 'property.description', 'Description'],
    ['ru', 'property.description', 'Описание'],
    ['sv', 'property.description', 'Beskrivning'],
    
    ['es', 'property.features', 'Características'],
    ['en', 'property.features', 'Features'],
    ['fr', 'property.features', 'Caractéristiques'],
    ['ru', 'property.features', 'Характеристики'],
    ['sv', 'property.features', 'Funktioner'],
    
    ['es', 'property.contact', 'Contactar'],
    ['en', 'property.contact', 'Contact'],
    ['fr', 'property.contact', 'Contacter'],
    ['ru', 'property.contact', 'Связаться'],
    ['sv', 'property.contact', 'Kontakta'],
    
    ['es', 'property.interest', '¿Te interesa esta propiedad?'],
    ['en', 'property.interest', 'Are you interested in this property?'],
    ['fr', 'property.interest', 'Cette propriété vous intéresse?'],
    ['ru', 'property.interest', 'Вас интересует этот объект?'],
    ['sv', 'property.interest', 'Är du intresserad av denna fastighet?'],
    
    ['es', 'property.contactNow', '¡Contáctanos ahora!'],
    ['en', 'property.contactNow', 'Contact us now!'],
    ['fr', 'property.contactNow', 'Contactez-nous maintenant!'],
    ['ru', 'property.contactNow', 'Свяжитесь с нами сейчас!'],
    ['sv', 'property.contactNow', 'Kontakta oss nu!']
];

// Preparar statement
$stmt = $conn->prepare("INSERT INTO translations (lang_code, translation_key, translation_value) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE translation_value = VALUES(translation_value)");

$inserted = 0;
$updated = 0;
$errors = 0;

foreach ($translations as $translation) {
    $stmt->bind_param("sss", $translation[0], $translation[1], $translation[2]);
    
    if ($stmt->execute()) {
        if ($conn->affected_rows === 1) {
            $inserted++;
        } else {
            $updated++;
        }
    } else {
        $errors++;
        echo "<div class='error'>❌ Error: " . $stmt->error . " (Key: {$translation[1]}, Lang: {$translation[0]})</div>";
    }
}

$stmt->close();

echo "<div class='success'>✅ Insertadas: $inserted traducciones</div>";
if ($updated > 0) {
    echo "<div class='info'>ℹ️ Actualizadas: $updated traducciones</div>";
}
if ($errors > 0) {
    echo "<div class='error'>❌ Errores: $errors</div>";
}

// Verificar traducciones por idioma
echo "<hr><h2>📊 Verificación por idioma:</h2>";
$langs = ['es', 'en', 'fr', 'ru', 'sv'];
foreach ($langs as $lang) {
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM translations WHERE lang_code = ?");
    $stmt->bind_param("s", $lang);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo "<div class='info'>📊 $lang: {$row['count']} traducciones</div>";
    $stmt->close();
}

echo "<hr>";
echo "<h2>✅ Proceso completado</h2>";
echo "<p><a href='index.php'>← Volver a la página principal</a></p>";
echo "</body></html>";
?>

