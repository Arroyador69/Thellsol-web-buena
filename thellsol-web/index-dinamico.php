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
    <title>TellSol Real Estate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
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
        .navbar {
            gap: 0;
            position: relative;
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
        .navbar-title {
            font-family: 'Cormorant Garamond', serif !important;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #fff;
            text-shadow: 0 1px 2px #0002;
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
        .hero {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('./images/hero.jpg');
            background-size: cover;
            background-position: center;
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }
        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        .hero-btn {
            background: #0a53e4;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        .hero-btn:hover {
            background: #003399;
        }
        .presentacion {
            padding: 80px 20px;
            text-align: center;
            background: white;
        }
        .presentacion h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #181e29;
        }
        .presentacion p {
            font-size: 1.1rem;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto 2rem;
            color: #666;
        }
        .presentacion-firma {
            font-size: 1.3rem;
            font-weight: bold;
            color: #181e29;
            margin-bottom: 0.5rem;
        }
        .presentacion-cargo {
            color: #666;
            font-style: italic;
        }
        .destacadas {
            padding: 80px 20px;
            background: #f8f9fa;
        }
        .destacadas h3 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #181e29;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: #181e29;
        }
        .card-zona {
            color: #666;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        .card-desc {
            color: #888;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }
        .card-precio {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0a53e4;
            margin-bottom: 15px;
        }
        .card-btn {
            background: #0a53e4;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
        }
        .card-btn:hover {
            background: #003399;
        }
        .footer {
            background: #181e29;
            color: white;
            padding: 60px 20px 30px;
        }
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
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
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
            .navbar-left, .navbar-right {
                display: none;
            }
            .hero-content h1 {
                font-size: 2.5rem;
            }
            .cards {
                grid-template-columns: 1fr;
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
            <a href="index-dinamico.php" class="navbar-link active">Inicio</a>
            <div class="dropdown">
                <a href="#" class="navbar-link">Propiedades</a>
                <div class="dropdown-content">
                    <a href="propiedades-dinamicas.php">Ver Todas</a>
                    <a href="comprar.html">Comprar</a>
                    <a href="vender.html">Vender</a>
                </div>
            </div>
            <a href="contacto.html" class="navbar-link">Contacto</a>
            <a href="informacion-legal.html" class="navbar-link">Información Legal</a>
        </div>
        <div class="navbar-right">
            <button class="mobile-menu-btn" onclick="openMobileMenu()">☰</button>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <h1>Bienvenido a TellSol Real Estate</h1>
            <p>Tu socio de confianza en la Costa del Sol</p>
            <a href="contacto.html" class="hero-btn">Contactar Ahora</a>
        </div>
    </section>

    <section class="presentacion">
        <h2>Bienvenido a TellSol Real Estate</h2>
        <p>Somos una empresa inmobiliaria especializada en la Costa del Sol, comprometida con ofrecer el mejor servicio y las mejores propiedades a nuestros clientes. Con años de experiencia en el mercado inmobiliario, te ayudamos a encontrar tu hogar ideal o a vender tu propiedad al mejor precio.</p>
        <div class="presentacion-firma">André Tell</div>
        <div class="presentacion-cargo">Fundador & CEO, Thellsol Real Estate</div>
    </section>

    <!-- Propiedades destacadas -->
    <section class="destacadas">
        <h3>Propiedades Destacadas</h3>
        <div class="cards">
            <?php if (!empty($properties)): ?>
                <?php foreach (array_slice($properties, 0, 8) as $property): ?>
                    <div class="card">
                        <img src="<?php echo !empty($property['images']) ? json_decode($property['images'], true)[0] ?? 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' : 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'; ?>" class="card-img" alt="<?php echo htmlspecialchars($property['title']); ?>">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo htmlspecialchars($property['title']); ?></h3>
                            <p class="card-zona"><?php echo htmlspecialchars($property['location']); ?></p>
                            <p class="card-desc">
                                <?php 
                                $desc = [];
                                if ($property['bedrooms']) $desc[] = $property['bedrooms'] . ' dormitorios';
                                if ($property['bathrooms']) $desc[] = $property['bathrooms'] . ' baños';
                                if ($property['area']) $desc[] = $property['area'] . 'm²';
                                echo implode(', ', $desc);
                                ?>
                            </p>
                            <p class="card-precio"><?php echo number_format($property['price']); ?>€</p>
                            <button class="card-btn" onclick="window.location.href='propiedades-dinamicas.php'">Ver Detalles</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Propiedades por defecto si no hay datos en Supabase -->
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="card-img" alt="Apartamento en Marbella">
                    <div class="card-body">
                        <h3 class="card-title">Apartamento de Lujo en Marbella</h3>
                        <p class="card-zona">Marbella, Costa del Sol</p>
                        <p class="card-desc">3 dormitorios, 2 baños, 120m²</p>
                        <p class="card-precio">450.000€</p>
                        <button class="card-btn">Ver Detalles</button>
                    </div>
                </div>
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="card-img" alt="Villa en Fuengirola">
                    <div class="card-body">
                        <h3 class="card-title">Villa con Piscina en Fuengirola</h3>
                        <p class="card-zona">Fuengirola, Costa del Sol</p>
                        <p class="card-desc">4 dormitorios, 3 baños, 250m²</p>
                        <p class="card-precio">650.000€</p>
                        <button class="card-btn">Ver Detalles</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 40px; align-items: start;">
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

    <script>
    function openMobileMenu() {
        // Implementar menú móvil si es necesario
        alert('Menú móvil - Implementar según necesidades');
    }
    </script>
</body>
</html>
