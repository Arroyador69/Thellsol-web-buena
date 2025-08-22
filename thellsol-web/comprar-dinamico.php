<?php
require_once 'supabase-connection.php';

// Obtener propiedades de Supabase
$supabase = new SupabaseConnection();
$result = $supabase->getProperties();
$properties = [];

if ($result['status'] === 200 && !empty($result['data'])) {
    $properties = $result['data'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar Propiedades | ThellSol Real Estate</title>
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
        .dropdown {
            position: relative;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #232a3a;
            min-width: 140px;
            box-shadow: 0 2px 8px #0002;
            border-radius: 0 0 6px 6px;
            overflow: hidden;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .dropdown-content a {
            color: #fff;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
            transition: background 0.2s;
        }
        .dropdown-content a:hover {
            background: #2f3a4d;
        }
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('./images/hero.jpg');
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }
        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        .properties-section {
            padding: 80px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .properties-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }
        .property-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .property-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        .property-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        .property-content {
            padding: 25px;
        }
        .property-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: #181e29;
            margin-bottom: 10px;
        }
        .property-location {
            color: #666;
            font-size: 1rem;
            margin-bottom: 15px;
        }
        .property-details {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            color: #888;
            font-size: 0.9rem;
        }
        .property-price {
            font-size: 1.8rem;
            font-weight: bold;
            color: #0a53e4;
            margin-bottom: 20px;
        }
        .property-btn {
            background: #0a53e4;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
            font-size: 1rem;
            font-weight: 500;
        }
        .property-btn:hover {
            background: #003399;
        }
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            color: #181e29;
            margin-bottom: 20px;
        }
        .section-subtitle {
            text-align: center;
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 40px;
        }
        .no-properties {
            text-align: center;
            padding: 60px 20px;
            color: #666;
            font-size: 1.2rem;
        }
        .footer {
            background: #181e29;
            color: white;
            padding: 60px 20px 30px;
            margin-top: 80px;
        }
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
        }
        .footer-section h4 {
            margin-bottom: 15px;
            color: #fff;
        }
        .footer-section a {
            color: #ccc;
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
            transition: color 0.3s;
        }
        .footer-section a:hover {
            color: #0a53e4;
        }
        .whatsapp-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: #25d366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
            transition: transform 0.3s;
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
            .properties-grid {
                grid-template-columns: 1fr;
            }
            .hero-content h1 {
                font-size: 2rem;
            }
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <img src="./images/logo-thellsol.png" alt="Logo" class="navbar-logo">
            <span class="navbar-title">TellSol</span>
        </div>
        <div class="navbar-center">
            <a href="index-dinamico.php" class="navbar-link">Inicio</a>
            <div class="dropdown">
                <a href="#" class="navbar-link active">Propiedades</a>
                <div class="dropdown-content">
                    <a href="propiedades-dinamicas.php">Ver Todas</a>
                    <a href="comprar-dinamico.php">Comprar</a>
                    <a href="vender.html">Vender</a>
                </div>
            </div>
            <a href="contacto.html" class="navbar-link">Contacto</a>
            <a href="informacion-legal.html" class="navbar-link">Información Legal</a>
        </div>
        <div class="navbar-right">
            <a href="admin-dashboard.php" class="navbar-link" style="font-size: 0.9rem;">Admin</a>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-content">
            <h1>Propiedades en Venta</h1>
            <p>Descubre las mejores propiedades en la Costa del Sol</p>
        </div>
    </section>

    <section class="properties-section">
        <h2 class="section-title">Propiedades Disponibles</h2>
        <p class="section-subtitle">Encuentra tu hogar ideal en la Costa del Sol</p>
        
        <?php if (!empty($properties)): ?>
            <div class="properties-grid">
                <?php foreach ($properties as $property): ?>
                    <div class="property-card">
                        <img src="<?php echo !empty($property['images']) ? json_decode($property['images'], true)[0] ?? 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' : 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'; ?>" class="property-image" alt="<?php echo htmlspecialchars($property['title']); ?>">
                        <div class="property-content">
                            <h3 class="property-title"><?php echo htmlspecialchars($property['title']); ?></h3>
                            <p class="property-location"><?php echo htmlspecialchars($property['location']); ?></p>
                            <div class="property-details">
                                <?php if ($property['bedrooms']): ?>
                                    <span><?php echo $property['bedrooms']; ?> dormitorios</span>
                                <?php endif; ?>
                                <?php if ($property['bathrooms']): ?>
                                    <span><?php echo $property['bathrooms']; ?> baños</span>
                                <?php endif; ?>
                                <?php if ($property['area']): ?>
                                    <span><?php echo $property['area']; ?>m²</span>
                                <?php endif; ?>
                            </div>
                            <p class="property-price"><?php echo number_format($property['price']); ?>€</p>
                            <button class="property-btn" onclick="window.location.href='propiedades-dinamicas.php'">Ver Detalles</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-properties">
                <h3>No hay propiedades disponibles en este momento</h3>
                <p>Pronto añadiremos nuevas propiedades. ¡Mantente atento!</p>
                <p><a href="contacto.html" style="color: #0a53e4; text-decoration: none;">Contacta con nosotros</a> para más información.</p>
            </div>
        <?php endif; ?>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>Contacto</h4>
                <p><b>Andre Richard Tell</b><br>Thellsol Real Estate</p>
                <p>Fuengirola 29640<br>Málaga, Spain</p>
            </div>
            <div class="footer-section">
                <p style="margin-bottom: 0;">andre@thellsol.com</p>
                <p style="margin-top: 0;">+34 676 335 313</p>
            </div>
            <div class="footer-section">
                <h4>Enlaces Legales</h4>
                <a href="politica-privacidad.html">Política de Privacidad</a>
                <a href="politica-cookies.html">Política de Cookies</a>
                <a href="aviso-legal.html">Aviso Legal</a>
            </div>
            <div class="footer-section" style="text-align: right;">
                <a href="https://thellsol.com" target="_blank"><img src="./images/logo-thellsol.png" alt="Logo Thellsol" style="width: 120px; border-radius: 12px;"></a>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px; font-size: 0.95rem; color: #ccc;">
            <span>Developed by DesArroyo Tech</span>
            <span>thellsol.com copyright reserved 2025</span>
        </div>
    </footer>

    <a href="https://wa.me/34676335313" class="whatsapp-button" target="_blank">
        <img src="./images/whatsapp-icon.png" alt="WhatsApp">
    </a>
</body>
</html>
