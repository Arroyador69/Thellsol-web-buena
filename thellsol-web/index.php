<?php
// Obtener propiedades del dashboard usando la API
$apiUrl = 'dashboard-api.php';
$properties = [];

try {
    $response = file_get_contents($apiUrl);
    if ($response !== false) {
        $data = json_decode($response, true);
        if ($data && $data['success']) {
            $properties = $data['properties'] ?? [];
        }
    }
} catch (Exception $e) {
    // Error silencioso, usar propiedades de ejemplo
}

// Si no hay propiedades del dashboard, no mostrar nada
// (Solo mostrar propiedades creadas en el dashboard)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | ThellSol Real Estate</title>
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
        @media (max-width: 900px) {
            .navbar { padding: 0 10px; }
            .navbar-title { font-size: 20px; }
            .navbar-link { font-size: 13px; }
        }
        @media (max-width: 768px) {
            .navbar-logo,
            .navbar-title,
            .navbar-left,
            .navbar-right {
                display: none !important;
            }
            .navbar-mobile-title {
                display: block !important;
            }
            .hamburger {
                display: flex !important;
            }
        }
        .navbar-mobile-title {
            display: none;
            width: 100%;
            text-align: center;
            font-family: 'Cormorant Garamond', serif !important;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: #fff;
            background: #181e29;
            padding: 10px 0 0 0;
            z-index: 1201;
        }
        .hamburger {
            display: none;
            position: fixed;
            top: 18px;
            right: 18px;
            width: 44px;
            height: 44px;
            background: #181e29;
            border: none;
            border-radius: 50%;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            z-index: 1201;
        }
        .hamburger span {
            width: 22px;
            height: 2px;
            background: #fff;
            margin: 2px 0;
            transition: 0.3s;
        }
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 280px;
            height: 100vh;
            background: #181e29;
            z-index: 1200;
            display: flex;
            flex-direction: column;
            padding: 80px 20px 20px;
            transition: right 0.3s ease;
        }
        .mobile-menu.open {
            right: 0;
        }
        .mobile-menu a {
            color: #fff;
            text-decoration: none;
            padding: 15px 0;
            border-bottom: 1px solid #232a3a;
            font-size: 16px;
        }
        .mobile-menu-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1199;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .mobile-menu-bg.open {
            opacity: 1;
            visibility: visible;
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
            font-size: 1.8rem;
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
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
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
            text-decoration: none;
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
        @media (max-width: 600px) {
            .navbar {
                flex-direction: column;
                height: auto;
                padding: 8px 0;
            }
            .navbar-left, .navbar-center, .navbar-right {
                position: static !important;
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
                margin: 0;
                height: auto;
            }
            .navbar-title {
                font-size: 1.1rem;
                text-align: center;
                width: 100%;
            }
            .presentacion-fotos {
                flex-direction: column;
                gap: 20px;
            }
            .footer-content {
                grid-template-columns: 1fr;
                gap: 18px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-mobile-title">ThellSol Real Estate</div>
        <button class="hamburger" id="hamburgerBtn" aria-label="Abrir menú" onclick="openMobileMenu()">
          <span></span>
          <span></span>
          <span></span>
        </button>
        <div class="navbar-left">
            <img src="./images/logo-thellsol.png" alt="Logo Thellsol" class="navbar-logo" />
            <a href="index.php" class="navbar-link active">Inicio</a>
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
    <div class="mobile-menu-bg" id="mobileMenuBg" onclick="closeMobileMenu()"></div>
    <div class="mobile-menu" id="mobileMenu">
      <a href="index.php">Inicio</a>
      <a href="comprar.php">Comprar</a>
      <a href="vender.html">Vender</a>
      <a href="informacion-legal.html">Información Legal</a>
      <a href="contacto.html">Contacto</a>
      <a href="admin-dashboard.php">Admin</a>
    </div>

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
                        <img src="<?php echo !empty($property['images']) ? (is_array($property['images']) ? $property['images'][0] : json_decode($property['images'], true)[0]) ?? 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' : 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'; ?>" class="card-img" alt="<?php echo htmlspecialchars($property['title']); ?>">
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
                            <a href="propiedad-detalles.php?id=<?php echo urlencode($property['id']); ?>" class="card-btn">Ver Detalles</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Mensaje cuando no hay propiedades -->
                <div class="card" style="text-align: center; padding: 40px; grid-column: 1 / -1;">
                    <h3>🏠 Próximamente nuevas propiedades</h3>
                    <p>Estamos trabajando para ofrecerte las mejores opciones inmobiliarias en la Costa del Sol.</p>
                    <a href="contacto.html" class="card-btn">Contactar</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

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
</body>
<script>
function openMobileMenu() {
  document.getElementById('mobileMenu').classList.add('open');
  document.getElementById('mobileMenuBg').classList.add('open');
}
function closeMobileMenu() {
  document.getElementById('mobileMenu').classList.remove('open');
  document.getElementById('mobileMenuBg').classList.remove('open');
}
// Banner de cookies
(function() {
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }
    if (!getCookie('cookies_accepted')) {
        var banner = document.createElement('div');
        banner.id = 'cookie-banner';
        banner.innerHTML = `
            <div class="cookie-banner-content">
                Utilizamos cookies propias y de terceros para mejorar tu experiencia y analizar el uso de la web. <a href="politica-cookies.html" style="color:#0a53e4;text-decoration:underline;">Más información</a>.
                <button id="accept-cookies-btn">Aceptar</button>
            </div>
        `;
        document.body.appendChild(banner);
        document.getElementById('accept-cookies-btn').onclick = function() {
            setCookie('cookies_accepted', 'yes', 30);
            banner.style.display = 'none';
        };
        // Estilos
        var style = document.createElement('style');
        style.innerHTML = `
        #cookie-banner {
            position: fixed;
            left: 0; right: 0; bottom: 0;
            background: #181e29;
            color: #fff;
            padding: 18px 10px 18px 10px;
            box-shadow: 0 -2px 12px #0003;
            z-index: 2000;
            font-size: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .cookie-banner-content {
            max-width: 700px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 18px;
            justify-content: center;
        }
        #accept-cookies-btn {
            background: #0a53e4;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 8px 22px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
            box-shadow: 0 1px 4px #0002;
        }
        #accept-cookies-btn:hover {
            background: #003399;
        }
        @media (max-width: 600px) {
            .cookie-banner-content { font-size: 0.95rem; gap: 8px; }
            #accept-cookies-btn { padding: 8px 12px; font-size: 0.95rem; }
        }
        `;
        document.head.appendChild(style);
    }
})();
</script>
</html>
