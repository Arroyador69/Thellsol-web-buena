-- ============================================
-- TRADUCCIONES COMPLETAS - TODAS LAS PÁGINAS
-- Ejecutar este script en phpMyAdmin → SQL
-- Este script actualiza traducciones existentes o las inserta si no existen
-- ============================================

-- FILTROS Y BÚSQUEDA (comprar.php)
INSERT INTO translations (lang_code, translation_key, translation_value) VALUES
('en', 'buy.filters', 'Search Filters'),
('es', 'buy.filters', 'Filtros de Búsqueda'),
('fr', 'buy.filters', 'Filtres de Recherche'),
('ru', 'buy.filters', 'Фильтры Поиска'),
('sv', 'buy.filters', 'Sökfilter'),

('en', 'buy.allLocations', 'All locations'),
('es', 'buy.allLocations', 'Todas las ubicaciones'),
('fr', 'buy.allLocations', 'Tous les emplacements'),
('ru', 'buy.allLocations', 'Все местоположения'),
('sv', 'buy.allLocations', 'Alla platser'),

('en', 'buy.allTypes', 'All types'),
('es', 'buy.allTypes', 'Todos los tipos'),
('fr', 'buy.allTypes', 'Tous les types'),
('ru', 'buy.allTypes', 'Все типы'),
('sv', 'buy.allTypes', 'Alla typer'),

('en', 'buy.minPrice', 'Minimum Price'),
('es', 'buy.minPrice', 'Precio mínimo'),
('fr', 'buy.minPrice', 'Prix minimum'),
('ru', 'buy.minPrice', 'Минимальная Цена'),
('sv', 'buy.minPrice', 'Lägsta Pris'),

('en', 'buy.maxPrice', 'Maximum Price'),
('es', 'buy.maxPrice', 'Precio máximo'),
('fr', 'buy.maxPrice', 'Prix maximum'),
('ru', 'buy.maxPrice', 'Максимальная Цена'),
('sv', 'buy.maxPrice', 'Högsta Pris'),

('en', 'buy.rooms', 'Rooms'),
('es', 'buy.rooms', 'Habitaciones'),
('fr', 'buy.rooms', 'Chambres'),
('ru', 'buy.rooms', 'Комнаты'),
('sv', 'buy.rooms', 'Rum'),

('en', 'buy.anyNumber', 'Any number'),
('es', 'buy.anyNumber', 'Cualquier número'),
('fr', 'buy.anyNumber', 'N\'importe quel nombre'),
('ru', 'buy.anyNumber', 'Любое количество'),
('sv', 'buy.anyNumber', 'Vilket antal som helst'),

('en', 'buy.bedroom', 'bedroom'),
('es', 'buy.bedroom', 'dormitorio'),
('fr', 'buy.bedroom', 'chambre'),
('ru', 'buy.bedroom', 'спальня'),
('sv', 'buy.bedroom', 'sovrum'),

('en', 'buy.bedrooms', 'bedrooms'),
('es', 'buy.bedrooms', 'dormitorios'),
('fr', 'buy.bedrooms', 'chambres'),
('ru', 'buy.bedrooms', 'спальни'),
('sv', 'buy.bedrooms', 'sovrum'),

('en', 'buy.filterButton', 'Filter Properties'),
('es', 'buy.filterButton', 'Filtrar Propiedades'),
('fr', 'buy.filterButton', 'Filtrer les Propriétés'),
('ru', 'buy.filterButton', 'Фильтровать Объекты'),
('sv', 'buy.filterButton', 'Filtrera Fastigheter'),

('en', 'buy.availableProperties', 'Available Properties'),
('es', 'buy.availableProperties', 'Propiedades Disponibles'),
('fr', 'buy.availableProperties', 'Propriétés Disponibles'),
('ru', 'buy.availableProperties', 'Доступные Объекты'),
('sv', 'buy.availableProperties', 'Tillgängliga Fastigheter'),

('en', 'buy.propertiesFound', 'properties found'),
('es', 'buy.propertiesFound', 'propiedades encontradas'),
('fr', 'buy.propertiesFound', 'propriétés trouvées'),
('ru', 'buy.propertiesFound', 'объектов найдено'),
('sv', 'buy.propertiesFound', 'fastigheter hittades'),

('en', 'buy.propertyType', 'Property Type'),
('es', 'buy.propertyType', 'Tipo de Propiedad'),
('fr', 'buy.propertyType', 'Type de Propriété'),
('ru', 'buy.propertyType', 'Тип Недвижимости'),
('sv', 'buy.propertyType', 'Fastighetstyp'),

('en', 'buy.forSale', 'For Sale'),
('es', 'buy.forSale', 'En Venta'),
('fr', 'buy.forSale', 'À Vendre'),
('ru', 'buy.forSale', 'В Продаже'),
('sv', 'buy.forSale', 'Till Salu'),

('en', 'buy.sold', 'Sold'),
('es', 'buy.sold', 'Vendida'),
('fr', 'buy.sold', 'Vendue'),
('ru', 'buy.sold', 'Продано'),
('sv', 'buy.sold', 'Såld'),

('en', 'buy.viewDetails', 'View Details'),
('es', 'buy.viewDetails', 'Ver Detalles'),
('fr', 'buy.viewDetails', 'Voir les Détails'),
('ru', 'buy.viewDetails', 'Подробнее'),
('sv', 'buy.viewDetails', 'Visa Detaljer'),

-- HERO SECTION (comprar.php)
('en', 'buy.heroTitle', 'Properties for Sale'),
('es', 'buy.heroTitle', 'Propiedades en Venta'),
('fr', 'buy.heroTitle', 'Propriétés à Vendre'),
('ru', 'buy.heroTitle', 'Недвижимость в Продаже'),
('sv', 'buy.heroTitle', 'Fastigheter till Salu'),

('en', 'buy.heroSubtitle', 'Find your ideal home on the Costa del Sol'),
('es', 'buy.heroSubtitle', 'Encuentra tu hogar ideal en la Costa del Sol'),
('fr', 'buy.heroSubtitle', 'Trouvez votre maison idéale sur la Costa del Sol'),
('ru', 'buy.heroSubtitle', 'Найдите свой идеальный дом на Коста-дель-Соль'),
('sv', 'buy.heroSubtitle', 'Hitta ditt ideala hem på Costa del Sol'),

-- TIPOS DE PROPIEDADES
('en', 'property.type.apartment', 'Apartment'),
('es', 'property.type.apartment', 'Apartamento'),
('fr', 'property.type.apartment', 'Appartement'),
('ru', 'property.type.apartment', 'Квартира'),
('sv', 'property.type.apartment', 'Lägenhet'),

('en', 'property.type.house', 'House'),
('es', 'property.type.house', 'Casa'),
('fr', 'property.type.house', 'Maison'),
('ru', 'property.type.house', 'Дом'),
('sv', 'property.type.house', 'Hus'),

('en', 'property.type.villa', 'Villa'),
('es', 'property.type.villa', 'Villa'),
('fr', 'property.type.villa', 'Villa'),
('ru', 'property.type.villa', 'Вилла'),
('sv', 'property.type.villa', 'Villa'),

('en', 'property.type.chalet', 'Chalet'),
('es', 'property.type.chalet', 'Chalet'),
('fr', 'property.type.chalet', 'Chalet'),
('ru', 'property.type.chalet', 'Шале'),
('sv', 'property.type.chalet', 'Chalet'),

('en', 'property.type.penthouse', 'Penthouse'),
('es', 'property.type.penthouse', 'Ático'),
('fr', 'property.type.penthouse', 'Penthouse'),
('ru', 'property.type.penthouse', 'Пентхаус'),
('sv', 'property.type.penthouse', 'Penthouse'),

('en', 'property.type.studio', 'Studio'),
('es', 'property.type.studio', 'Estudio'),
('fr', 'property.type.studio', 'Studio'),
('ru', 'property.type.studio', 'Студия'),
('sv', 'property.type.studio', 'Studio'),

-- UBICACIONES
('en', 'location.marbella', 'Marbella'),
('es', 'location.marbella', 'Marbella'),
('fr', 'location.marbella', 'Marbella'),
('ru', 'location.marbella', 'Марбелья'),
('sv', 'location.marbella', 'Marbella'),

('en', 'location.fuengirola', 'Fuengirola'),
('es', 'location.fuengirola', 'Fuengirola'),
('fr', 'location.fuengirola', 'Fuengirola'),
('ru', 'location.fuengirola', 'Фуэнхирола'),
('sv', 'location.fuengirola', 'Fuengirola'),

('en', 'location.benalmadena', 'Benalmádena'),
('es', 'location.benalmadena', 'Benalmádena'),
('fr', 'location.benalmadena', 'Benalmádena'),
('ru', 'location.benalmadena', 'Бенальмадена'),
('sv', 'location.benalmadena', 'Benalmádena'),

('en', 'location.torremolinos', 'Torremolinos'),
('es', 'location.torremolinos', 'Torremolinos'),
('fr', 'location.torremolinos', 'Torremolinos'),
('ru', 'location.torremolinos', 'Торремолинос'),
('sv', 'location.torremolinos', 'Torremolinos'),

('en', 'location.mijas', 'Mijas'),
('es', 'location.mijas', 'Mijas'),
('fr', 'location.mijas', 'Mijas'),
('ru', 'location.mijas', 'Михас'),
('sv', 'location.mijas', 'Mijas'),

-- BREADCRUMBS
('en', 'breadcrumb.properties', 'Properties'),
('es', 'breadcrumb.properties', 'Propiedades'),
('fr', 'breadcrumb.properties', 'Propriétés'),
('ru', 'breadcrumb.properties', 'Недвижимость'),
('sv', 'breadcrumb.properties', 'Fastigheter'),

-- UBICACIÓN (LABEL)
('en', 'buy.location', 'Location'),
('es', 'buy.location', 'Ubicación'),
('fr', 'buy.location', 'Emplacement'),
('ru', 'buy.location', 'Местоположение'),
('sv', 'buy.location', 'Plats'),

-- BAÑOS
('en', 'property.bathroom', 'bathroom'),
('es', 'property.bathroom', 'baño'),
('fr', 'property.bathroom', 'salle de bain'),
('ru', 'property.bathroom', 'ванная'),
('sv', 'property.bathroom', 'badrum'),

('en', 'property.bathrooms', 'bathrooms'),
('es', 'property.bathrooms', 'baños'),
('fr', 'property.bathrooms', 'salles de bain'),
('ru', 'property.bathrooms', 'ванные'),
('sv', 'property.bathrooms', 'badrum'),

-- DETALLE PROPIEDAD
('en', 'property.characteristics', 'Property Details'),
('es', 'property.characteristics', 'Características'),
('fr', 'property.characteristics', 'Caractéristiques'),
('ru', 'property.characteristics', 'Характеристики'),
('sv', 'property.characteristics', 'Egenskaper'),

('en', 'property.features', 'Amenities'),
('es', 'property.features', 'Características'),
('fr', 'property.features', 'Équipements'),
('ru', 'property.features', 'Удобства'),
('sv', 'property.features', 'Bekvämligheter'),

('en', 'property.area', 'Area'),
('es', 'property.area', 'Superficie'),
('fr', 'property.area', 'Surface'),
('ru', 'property.area', 'Площадь'),
('sv', 'property.area', 'Yta'),

('en', 'property.typeLabel', 'Type'),
('es', 'property.typeLabel', 'Tipo'),
('fr', 'property.typeLabel', 'Type'),
('ru', 'property.typeLabel', 'Тип'),
('sv', 'property.typeLabel', 'Typ'),

('en', 'property.contact', 'Contact'),
('es', 'property.contact', 'Contactar'),
('fr', 'property.contact', 'Contacter'),
('ru', 'property.contact', 'Связаться'),
('sv', 'property.contact', 'Kontakta'),

('en', 'property.contactText', 'Are you interested in this property?\\nContact us now!'),
('es', 'property.contactText', '¿Te interesa esta propiedad?\\n¡Contáctanos ahora!'),
('fr', 'property.contactText', 'Cette propriété vous intéresse ?\\nContactez-nous dès maintenant !'),
('ru', 'property.contactText', 'Вас интересует этот объект?\\nСвяжитесь с нами!'),
('sv', 'property.contactText', 'Intresserad av den här bostaden?\\nKontakta oss nu!'),

('en', 'property.contactWhatsApp', 'WhatsApp'),
('es', 'property.contactWhatsApp', 'WhatsApp'),
('fr', 'property.contactWhatsApp', 'WhatsApp'),
('ru', 'property.contactWhatsApp', 'WhatsApp'),
('sv', 'property.contactWhatsApp', 'WhatsApp'),

('en', 'property.contactEmail', 'Email'),
('es', 'property.contactEmail', 'Email'),
('fr', 'property.contactEmail', 'E-mail'),
('ru', 'property.contactEmail', 'Email'),
('sv', 'property.contactEmail', 'E-post'),

('en', 'property.description', 'Description'),
('es', 'property.description', 'Descripción'),
('fr', 'property.description', 'Description'),
('ru', 'property.description', 'Описание'),
('sv', 'property.description', 'Beskrivning'),

('en', 'property.status.available', 'Available'),
('es', 'property.status.available', 'Disponible'),
('fr', 'property.status.available', 'Disponible'),
('ru', 'property.status.available', 'Доступно'),
('sv', 'property.status.available', 'Tillgänglig'),

('en', 'property.status.sold', 'Sold'),
('es', 'property.status.sold', 'Vendida'),
('fr', 'property.status.sold', 'Vendue'),
('ru', 'property.status.sold', 'Продано'),
('sv', 'property.status.sold', 'Såld'),

('en', 'property.feature.pool', 'Pool'),
('es', 'property.feature.pool', 'Piscina'),
('fr', 'property.feature.pool', 'Piscine'),
('ru', 'property.feature.pool', 'Бассейн'),
('sv', 'property.feature.pool', 'Pool'),

('en', 'property.feature.garden', 'Garden'),
('es', 'property.feature.garden', 'Jardín'),
('fr', 'property.feature.garden', 'Jardin'),
('ru', 'property.feature.garden', 'Сад'),
('sv', 'property.feature.garden', 'Trädgård'),

('en', 'property.feature.garage', 'Garage'),
('es', 'property.feature.garage', 'Garaje'),
('fr', 'property.feature.garage', 'Garage'),
('ru', 'property.feature.garage', 'Гараж'),
('sv', 'property.feature.garage', 'Garage'),

('en', 'property.feature.terrace', 'Terrace'),
('es', 'property.feature.terrace', 'Terraza'),
('fr', 'property.feature.terrace', 'Terrasse'),
('ru', 'property.feature.terrace', 'Терраса'),
('sv', 'property.feature.terrace', 'Terrass'),

('en', 'property.feature.seaView', 'Sea view'),
('es', 'property.feature.seaView', 'Vista al mar'),
('fr', 'property.feature.seaView', 'Vue sur la mer'),
('ru', 'property.feature.seaView', 'Вид на море'),
('sv', 'property.feature.seaView', 'Havsutsikt'),

('en', 'property.feature.airConditioning', 'Air conditioning'),
('es', 'property.feature.airConditioning', 'Aire acondicionado'),
('fr', 'property.feature.airConditioning', 'Climatisation'),
('ru', 'property.feature.airConditioning', 'Кондиционер'),
('sv', 'property.feature.airConditioning', 'Luftkonditionering'),

('en', 'property.feature.elevator', 'Elevator'),
('es', 'property.feature.elevator', 'Ascensor'),
('fr', 'property.feature.elevator', 'Ascenseur'),
('ru', 'property.feature.elevator', 'Лифт'),
('sv', 'property.feature.elevator', 'Hiss'),

('en', 'property.feature.fireplace', 'Fireplace'),
('es', 'property.feature.fireplace', 'Chimenea'),
('fr', 'property.feature.fireplace', 'Cheminée'),
('ru', 'property.feature.fireplace', 'Камин'),
('sv', 'property.feature.fireplace', 'Öppen spis'),

('en', 'property.feature.swimmingPool', 'Swimming pool'),
('es', 'property.feature.swimmingPool', 'Piscina'),
('fr', 'property.feature.swimmingPool', 'Piscine'),
('ru', 'property.feature.swimmingPool', 'Бассейн'),
('sv', 'property.feature.swimmingPool', 'Pool'),

('en', 'property.feature.balcony', 'Balcony'),
('es', 'property.feature.balcony', 'Balcón'),
('fr', 'property.feature.balcony', 'Balcon'),
('ru', 'property.feature.balcony', 'Балкон'),
('sv', 'property.feature.balcony', 'Balkong')

ON DUPLICATE KEY UPDATE translation_value = VALUES(translation_value);
