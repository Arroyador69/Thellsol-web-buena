<?php
// Página de detalles de una propiedad específica - Sistema MySQL
require_once 'db-config.php';

$conn = getDBConnection();
$property = null;

// Obtener ID de la propiedad de la URL
$propertyId = intval($_GET['id'] ?? 0);

if ($propertyId <= 0) {
    header('Location: index.php');
    exit();
}

// Cargar propiedad desde MySQL
$stmt = $conn->prepare("SELECT * FROM properties WHERE id = ? AND status = 'active'");
$stmt->bind_param("i", $propertyId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $property = $result->fetch_assoc();
    
    // Cargar características (features) de la propiedad
    $featuresStmt = $conn->prepare("SELECT feature_name FROM features WHERE property_id = ?");
    $featuresStmt->bind_param("i", $propertyId);
    $featuresStmt->execute();
    $featuresResult = $featuresStmt->get_result();
    $features = [];
    while ($featureRow = $featuresResult->fetch_assoc()) {
        $features[] = $featureRow['feature_name'];
    }
    $featuresStmt->close();
    $property['features'] = $features;
    
    // Procesar imágenes
    $images = [];
    if (!empty($property['image_url'])) {
        $images = [$property['image_url']];
    }
    
    // Si no hay imágenes, usar imágenes del carrusel como default
    if (empty($images)) {
        $images = [
            "images/carrusel2.jpeg",
            "images/carrusel3.jpeg", 
            "images/carrusel4.jpeg",
            "images/carrusel5.jpeg",
            "images/carrusel6.jpeg"
        ];
    }
    
    // Mapear campos para compatibilidad
    $property['surface'] = $property['area'];
} else {
    $stmt->close();
    header('Location: index.php');
    exit();
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($property['title']); ?> | ThellSol Real Estate</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="logo-thellsol copia.png" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fcf9f4;
        }
        .navbar-title {
            font-family: 'Cormorant Garamond', serif !important;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #fff;
            text-shadow: 0 1px 2px #0002;
        }
        .navbar {
            width: 100%;
            background: #181e29;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            height: 54px;
            box-sizing: border-box;
            position: sticky;
            top: 0;
            z-index: 100;
            gap: 0;
            position: relative;
        }
        .navbar-left {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-right: 18px;
            position: absolute;
            left: 2cm;
            top: 0;
            height: 54px;
        }
        .navbar-center {
            flex: 0 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 18px;
            position: absolute;
            right: 2cm;
            top: 0;
            height: 54px;
        }
        .navbar-logo {
            height: 36px;
            width: 36px;
            border-radius: 6px;
            background: #fff;
            object-fit: contain;
        }
        .navbar-link {
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 3px;
            transition: background 0.2s;
        }
        .navbar-link:hover, .navbar-link.active {
            background: #232a3a;
        }
        .navbar-right::after {
            content: '';
            display: inline-block;
            width: 60px;
            height: 1px;
        }
        
        .breadcrumb {
            background: #f8f9fa;
            padding: 15px 0;
            border-bottom: 1px solid #e1e5e9;
        }
        
        .breadcrumb-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .property-header {
            margin-bottom: 40px;
        }
        
        .property-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        
        .property-location {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 10px;
        }
        
        .property-price {
            font-size: 2rem;
            font-weight: bold;
            color: #0070f3;
            margin-bottom: 20px;
        }
        
        .property-status {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
        }
        
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        
        .status-sold {
            background: #f8d7da;
            color: #721c24;
        }
        
        .property-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .property-images {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .main-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            cursor: pointer;
        }
        
        .image-thumbnails {
            display: flex;
            gap: 10px;
            padding: 20px;
            overflow-x: auto;
        }
        
        .thumbnail {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s;
        }
        
        .thumbnail:hover,
        .thumbnail.active {
            opacity: 1;
        }
        
        .property-info {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            height: fit-content;
        }
        
        .info-section {
            margin-bottom: 30px;
        }
        
        .info-section h3 {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 2px solid #0070f3;
            padding-bottom: 5px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .info-label {
            font-weight: 600;
            color: #666;
        }
        
        .info-value {
            font-weight: bold;
            color: #333;
        }
        
        .contact-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }
        
        .contact-btn {
            background: #25D366;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            transition: transform 0.2s;
        }
        
        .contact-btn:hover {
            transform: translateY(-2px);
        }
        
        .contact-btn.email {
            background: #0070f3;
        }
        
        .property-description {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 40px;
        }
        
        .footer {
            background: #181e29;
            color: #fff;
            padding: 40px 20px;
            margin-top: 60px;
        }
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }
        .footer-section h4 {
            margin: 0 0 20px 0;
            font-size: 1.1rem;
            color: #fff;
        }
        .footer-section p {
            margin: 0 0 10px 0;
            color: #ccc;
            font-size: 0.9rem;
        }
        .footer-section a {
            color: #ccc;
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        .footer-section a:hover {
            color: #fff;
        }
        
        .whatsapp-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #25D366;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            transition: transform 0.2s;
            z-index: 1000;
        }
        .whatsapp-button:hover {
            transform: scale(1.1);
        }
        .whatsapp-button img {
            width: 35px;
            height: 35px;
        }
        
        @media (max-width: 768px) {
            .property-content {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .property-title {
                font-size: 2rem;
            }
            
            .main-image {
                height: 250px;
            }
            
            .navbar-logo,
            .navbar-title,
            .navbar-left,
            .navbar-right {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <img src="./images/logo-thellsol.png" alt="Logo Thellsol" class="navbar-logo" />
            <a href="index.php" class="navbar-link">Inicio</a>
            <a href="comprar.php" class="navbar-link">Comprar</a>
            <a href="vender.html" class="navbar-link">Vender</a>
        </div>
        <div class="navbar-center">
            <span class="navbar-title">ThellSol Real Estate</span>
        </div>
        <div class="navbar-right">
            <a href="informacion-legal.html" class="navbar-link">Información Legal</a>
            <a href="contacto.html" class="navbar-link">Contacto</a>
        </div>
    </nav>

    <div class="breadcrumb">
        <div class="breadcrumb-container">
            <a href="index.php">Inicio</a> / 
            <a href="comprar.php">Propiedades</a> / 
            <?php echo htmlspecialchars($property['title']); ?>
        </div>
    </div>

    <div class="container">
        <div class="property-header">
            <h1 class="property-title"><?php echo htmlspecialchars($property['title']); ?></h1>
            <p class="property-location">📍 <?php echo htmlspecialchars($property['location']); ?></p>
            <div class="property-price"><?php echo number_format($property['price']); ?>€</div>
            <span class="property-status status-<?php echo $property['status']; ?>">
                <?php echo $property['status'] === 'active' ? '✅ Disponible' : '❌ Vendida'; ?>
            </span>
        </div>

        <div class="property-content">
            <div class="property-images">
                <img src="<?php echo htmlspecialchars($images[0]); ?>" 
                     alt="<?php echo htmlspecialchars($property['title']); ?>" 
                     class="main-image" 
                     id="mainImage">
                
                <?php if (count($images) > 1): ?>
                    <div class="image-thumbnails">
                        <?php foreach ($images as $index => $image): ?>
                            <img src="<?php echo htmlspecialchars($image); ?>" 
                                 alt="Imagen <?php echo $index + 1; ?>" 
                                 class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>"
                                 onclick="changeMainImage('<?php echo htmlspecialchars($image); ?>', this)">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="property-info">
                <div class="info-section">
                    <h3>📋 Características</h3>
                    <div class="info-grid">
                        <?php if (!empty($property['bedrooms'])): ?>
                            <div class="info-item">
                                <span class="info-label">🛏️ Dormitorios</span>
                                <span class="info-value"><?php echo $property['bedrooms']; ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($property['bathrooms'])): ?>
                            <div class="info-item">
                                <span class="info-label">🚿 Baños</span>
                                <span class="info-value"><?php echo $property['bathrooms']; ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($property['area'])): ?>
                            <div class="info-item">
                                <span class="info-label">📐 Superficie</span>
                                <span class="info-value"><?php echo $property['area']; ?>m²</span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="info-item">
                            <span class="info-label">🏠 Tipo</span>
                            <span class="info-value"><?php echo ucfirst($property['type']); ?></span>
                        </div>
                    </div>
                    
                    <?php if (!empty($property['features'])): ?>
                        <div class="info-section" style="margin-top: 20px;">
                            <h3>✨ Características</h3>
                            <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;">
                                <?php 
                                $featureLabels = [
                                    'pool' => '🏊 Piscina',
                                    'garden' => '🌳 Jardín',
                                    'garage' => '🚗 Garaje',
                                    'terrace' => '🏡 Terraza',
                                    'seaView' => '🌊 Vista al mar',
                                    'airConditioning' => '❄️ Aire acondicionado',
                                    'elevator' => '🛗 Ascensor',
                                    'fireplace' => '🔥 Chimenea',
                                    'swimmingPool' => '🏊 Piscina',
                                    'balcony' => '🪟 Balcón'
                                ];
                                foreach ($property['features'] as $feature): 
                                    $label = $featureLabels[$feature] ?? '✨ ' . ucfirst($feature);
                                ?>
                                    <span style="background: #f0f0f0; padding: 8px 15px; border-radius: 20px; font-size: 0.9rem; color: #333;">
                                        <?php echo $label; ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="contact-section">
                    <h3>💬 Contactar</h3>
                    <p>¿Te interesa esta propiedad?<br>¡Contáctanos ahora!</p>
                    <a href="https://wa.me/34676335313?text=Hola,%20me%20interesa%20la%20propiedad:%20<?php echo urlencode($property['title']); ?>" 
                       class="contact-btn" target="_blank">
                        📱 WhatsApp
                    </a>
                    <a href="mailto:andre@thellsol.com?subject=Consulta%20sobre%20<?php echo urlencode($property['title']); ?>" 
                       class="contact-btn email">
                        ✉️ Email
                    </a>
                </div>
            </div>
        </div>

        <?php if (!empty($property['description'])): ?>
            <div class="property-description">
                <h3>📝 Descripción</h3>
                <p><?php echo nl2br(htmlspecialchars($property['description'])); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>Contacto</h4>
                <p><b>Andre Richard Tell</b><br>
                Thellsol Real Estate</p>
                <p>Fuengirola 29640<br>
                Málaga, Spain</p>
                <p><a href="mailto:andre@thellsol.com">andre@thellsol.com</a><br>
                +34 676 335 313</p>
            </div>
            <div class="footer-section">
                <h4>Enlaces Legales</h4>
                <a href="politica-privacidad.html">Política de Privacidad</a>
                <a href="politica-cookies.html">Política de Cookies</a>
                <a href="aviso-legal.html">Aviso Legal</a>
            </div>
        </div>
    </footer>

    <a href="https://wa.me/34676335313" class="whatsapp-button" target="_blank">
        <img src="./images/whatsapp-icon.png" alt="WhatsApp">
    </a>

    <script>
        function changeMainImage(src, element) {
            document.getElementById('mainImage').src = src;
            
            // Remover clase active de todos los thumbnails
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            
            // Agregar clase active al thumbnail clickeado
            element.classList.add('active');
        }
    </script>
</body>
</html>
