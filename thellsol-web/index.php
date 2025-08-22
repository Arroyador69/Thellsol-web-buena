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
            display: block;
            color: #fff;
            padding: 10px 16px;
            text-decoration: none;
            font-size: 15px;
            background: none;
            border: none;
            text-align: left;
        }
        .dropdown-content a:hover {
            background: #181e29;
        }
        .hero {
            width: 100%;
            max-width: 1100px;
            margin: 32px auto 0 auto;
            border-radius: 6px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 2px 8px #0001;
        }
        .hero-img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            display: block;
        }
        .hero-text {
            position: absolute;
            left: 0;
            bottom: 0;
            background: rgba(0,0,0,0.6);
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 10px 24px;
            border-radius: 0 12px 0 0;
        }
        .presentacion {
            max-width: 800px;
            margin: 32px auto 0 auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px #0001;
            padding: 32px 32px 24px 32px;
            text-align: center;
        }
        .presentacion h2 {
            font-family: 'Cormorant Garamond', serif !important;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .presentacion p.intro {
            font-size: 0.95rem;
            color: #444;
            margin-bottom: 18px;
        }
        .presentacion-fotos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
            margin-bottom: 18px;
        }
        .presentacion-foto {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #ccc;
            background: #fff;
            box-shadow: 0 2px 8px #0002;
        }
        .presentacion-logo {
            width: 120px;
            height: 120px;
            border-radius: 16px;
            object-fit: contain;
            background: #fff;
            border: 2px solid #ccc;
            box-shadow: 0 2px 8px #0002;
            padding: 8px;
        }
        .presentacion-texto {
            text-align: justify;
            color: #444;
            font-size: 0.97rem;
            margin-bottom: 10px;
        }
        .presentacion-firma {
            margin-top: 18px;
            font-weight: bold;
            font-size: 1rem;
        }
        .presentacion-cargo {
            font-size: 0.9rem;
            color: #888;
        }
        .destacadas {
            max-width: 1100px;
            margin: 40px auto 0 auto;
            padding-bottom: 40px;
        }
        .destacadas h3 {
            text-align: center;
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 24px;
        }
        .cards {
            display: flex;
            gap: 24px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px #0001;
            width: 270px;
            padding: 0 0 18px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .card-img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }
        .card-body {
            padding: 12px 18px 0 18px;
            width: 100%;
        }
        .card-title {
            font-weight: bold;
            font-size: 1rem;
            margin-bottom: 4px;
        }
        .card-zona, .card-desc {
            font-size: 0.92rem;
            color: #666;
            margin-bottom: 2px;
        }
        .card-precio {
            color: #0070f3;
            font-weight: bold;
            font-size: 1.1rem;
            margin: 8px 0 10px 0;
        }
        .card-btn {
            background: #0070f3;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 7px 18px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .card-btn:hover {
            background: #0051a2;
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
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <img src="./images/logo-thellsol.png" alt="Logo" class="navbar-logo">
            <span class="navbar-title">TellSol</span>
        </div>
        <div class="navbar-center">
            <a href="index.php" class="navbar-link active">Inicio</a>
            <div class="dropdown">
                <a href="#" class="navbar-link">Propiedades</a>
                <div class="dropdown-content">
                    <a href="propiedades-dinamicas.php">Ver Todas</a>
                    <a href="comprar.php">Comprar</a>
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

    <section class="hero">
        <img src="./images/hero.jpg" alt="Hero" class="hero-img">
        <div class="hero-text">Bienvenido a TellSol Real Estate</div>
    </section>

    <section class="presentacion">
        <h2>Bienvenido a TellSol Real Estate</h2>
        <p class="intro">Somos una empresa inmobiliaria especializada en la Costa del Sol, comprometida con ofrecer el mejor servicio y las mejores propiedades a nuestros clientes.</p>
        <div class="presentacion-fotos">
            <img src="./images/andre-tell.jpg" alt="André Tell" class="presentacion-foto">
            <img src="./images/logo-thellsol.png" alt="Logo TellSol" class="presentacion-logo">
        </div>
        <div class="presentacion-texto">
            Con más de una década de experiencia en la Costa del Sol, me enorgullece poder ayudarte a encontrar tu hogar ideal en esta maravillosa región. Desde las playas de Fuengirola hasta las calles históricas de Málaga, cada rincón de nuestra zona tiene algo especial que ofrecer.
        </div>
        <div class="presentacion-texto">
            En TellSol, no solo vendemos propiedades; creamos relaciones duraderas basadas en la confianza, la transparencia y el compromiso con la excelencia. Mi equipo y yo estamos aquí para guiarte en cada paso del camino.
        </div>
        <div class="presentacion-firma">André Tell</div>
        <div class="presentacion-cargo">Fundador & CEO, Thellsol Real Estate</div>
    </section>

    <!-- Propiedades destacadas -->
    <section class="destacadas">
        <h3>Propiedades Destacadas</h3>
        <div class="cards">
            <?php if (!empty($properties)): ?>
                <?php foreach (array_slice($properties, 0, 12) as $property): ?>
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
                            <button class="card-btn">Ver Detalles</button>
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
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="card-img" alt="Chalet en Benalmádena">
                    <div class="card-body">
                        <h3 class="card-title">Chalet Moderno en Benalmádena</h3>
                        <p class="card-zona">Benalmádena, Costa del Sol</p>
                        <p class="card-desc">5 dormitorios, 4 baños, 300m²</p>
                        <p class="card-precio">850.000€</p>
                        <button class="card-btn">Ver Detalles</button>
                    </div>
                </div>
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="card-img" alt="Casa Adosada en Mijas">
                    <div class="card-body">
                        <h3 class="card-title">Casa Adosada en Mijas</h3>
                        <p class="card-zona">Mijas, Costa del Sol</p>
                        <p class="card-desc">3 dormitorios, 2 baños, 150m²</p>
                        <p class="card-precio">320.000€</p>
                        <button class="card-btn">Ver Detalles</button>
                    </div>
                </div>
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="card-img" alt="Ático en Torremolinos">
                    <div class="card-body">
                        <h3 class="card-title">Ático con Vistas al Mar</h3>
                        <p class="card-zona">Torremolinos, Costa del Sol</p>
                        <p class="card-desc">2 dormitorios, 2 baños, 90m²</p>
                        <p class="card-precio">280.000€</p>
                        <button class="card-btn">Ver Detalles</button>
                    </div>
                </div>
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="card-img" alt="Apartamento en Nueva Andalucía">
                    <div class="card-body">
                        <h3 class="card-title">Apartamento en Nueva Andalucía</h3>
                        <p class="card-zona">Nueva Andalucía, Marbella</p>
                        <p class="card-desc">2 dormitorios, 2 baños, 85m²</p>
                        <p class="card-precio">350.000€</p>
                        <button class="card-btn">Ver Detalles</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
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
