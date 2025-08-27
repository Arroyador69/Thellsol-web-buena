<?php
// Página de comprar - Sistema JSON directo (IGUAL QUE INDEX)
// Archivo: comprar.php

$propertiesFile = "properties.json";
$properties = [];

// Cargar propiedades desde el archivo JSON
if (file_exists($propertiesFile)) {
    $content = file_get_contents($propertiesFile);
    $properties = json_decode($content, true) ?: [];
}

// Solo mostrar propiedades creadas en el dashboard
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar Propiedades - TellSol Real Estate</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
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
        
        .hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url("https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80");
            background-size: cover;
            background-position: center;
            padding: 4rem 2rem;
            text-align: center;
            color: white;
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .filters {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .filters h2 {
            margin-bottom: 1rem;
            color: #333;
        }
        
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
        }
        
        .filter-group label {
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #666;
        }
        
        .filter-group select,
        .filter-group input {
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .filter-btn {
            background: #0070f3;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        
        .filter-btn:hover {
            background: #0051a2;
        }
        
        .properties-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .properties-count {
            font-size: 1.2rem;
            color: #666;
        }
        
        .properties-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .property-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .property-card:hover {
            transform: translateY(-5px);
        }
        
        .property-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        
        .property-content {
            padding: 1.5rem;
        }
        
        .property-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #333;
        }
        
        .property-location {
            color: #666;
            margin-bottom: 1rem;
        }
        
        .property-details {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .property-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0070f3;
            margin-bottom: 1rem;
        }
        
        .property-btn {
            background: #0070f3;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .property-btn:hover {
            background: #0051a2;
        }
        
        .property-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        
        .status-sold {
            background: #f8d7da;
            color: #721c24;
        }
        
        .footer {
            background: #181e29;
            color: white;
            padding: 3rem 2rem;
            margin-top: 4rem;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        
        .footer-section h4 {
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }
        
        .footer-section p,
        .footer-section a {
            color: #ccc;
            text-decoration: none;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .footer-section a:hover {
            color: white;
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
            .hero h1 {
                font-size: 2rem;
            }
            .properties-grid {
                grid-template-columns: 1fr;
            }
            .filter-grid {
                grid-template-columns: 1fr;
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
            <a href="index.php" class="navbar-link">Inicio</a>
            <a href="comprar.php" class="navbar-link active">Comprar</a>
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
        <h1>Propiedades en Venta</h1>
        <p>Encuentra tu hogar ideal en la Costa del Sol</p>
    </section>

    <main class="container">
        <div class="filters">
            <h2>Filtros de Búsqueda</h2>
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="location">Ubicación</label>
                    <select id="location">
                        <option value="">Todas las ubicaciones</option>
                        <option value="marbella">Marbella</option>
                        <option value="fuengirola">Fuengirola</option>
                        <option value="benalmadena">Benalmádena</option>
                        <option value="torremolinos">Torremolinos</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="type">Tipo de Propiedad</label>
                    <select id="type">
                        <option value="">Todos los tipos</option>
                        <option value="apartment">Apartamento</option>
                        <option value="house">Casa</option>
                        <option value="villa">Villa</option>
                        <option value="chalet">Chalet</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="min-price">Precio mínimo</label>
                    <input type="number" id="min-price" placeholder="€">
            </div>
                
                <div class="filter-group">
                    <label for="max-price">Precio máximo</label>
                    <input type="number" id="max-price" placeholder="€">
                </div>
                
                <div class="filter-group">
                    <label for="bedrooms">Habitaciones</label>
                    <select id="bedrooms">
                        <option value="">Cualquier número</option>
                        <option value="1">1 dormitorio</option>
                        <option value="2">2 dormitorios</option>
                        <option value="3">3 dormitorios</option>
                        <option value="4">4+ dormitorios</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <button class="filter-btn" onclick="filterProperties()">Filtrar Propiedades</button>
                </div>
            </div>
        </div>

        <div class="properties-header">
            <h2>Propiedades Disponibles</h2>
            <div class="properties-count"><?php echo count($properties); ?> propiedades encontradas</div>
        </div>

        <div class="properties-grid" id="properties-grid">
                    <?php foreach ($properties as $property): ?>
                <div class="property-card" data-location="<?php echo strtolower($property['location']); ?>" 
                     data-type="<?php echo $property['type']; ?>" 
                     data-price="<?php echo $property['price']; ?>"
                     data-bedrooms="<?php echo $property['bedrooms'] ?? 0; ?>">
                    <img src="<?php 
                        $images = is_array($property["images"] ?? null) ? $property["images"] : [];
                        if (!empty($images) && !empty($images[0])) {
                            $imageUrl = $images[0];
                            // Si es URL de ejemplo, usar imagen por defecto
                            if (str_contains($imageUrl, 'example.com')) {
                                echo "images/carrusel4.jpeg"; // Usar imagen del carrusel como default
                            } else {
                                echo htmlspecialchars($imageUrl);
                            }
                        } else {
                            echo "images/carrusel5.jpeg"; // Imagen por defecto del carrusel
                        }
                    ?>" alt="<?php echo htmlspecialchars($property["title"]); ?>" class="property-image">
                    
                    <div class="property-content">
                        <span class="property-status status-<?php echo $property['status']; ?>">
                            <?php echo $property['status'] === 'active' ? 'En Venta' : 'Vendida'; ?>
                        </span>
                        
                        <h3 class="property-title"><?php echo htmlspecialchars($property["title"]); ?></h3>
                        <p class="property-location"><?php echo htmlspecialchars($property["location"]); ?></p>
                        
                        <div class="property-details">
                            <?php if (!empty($property["bedrooms"])): ?>
                                <span><?php echo $property["bedrooms"]; ?> dormitorios</span>
                            <?php endif; ?>
                            <?php if (!empty($property["bathrooms"])): ?>
                                <span><?php echo $property["bathrooms"]; ?> baños</span>
                            <?php endif; ?>
                            <?php if (!empty($property["area"])): ?>
                                <span><?php echo $property["area"]; ?>m²</span>
                            <?php endif; ?>
                        </div>
                        
                        <p class="property-price"><?php echo number_format($property["price"]); ?>€</p>
                                                 <a href="propiedad-detalles.php?id=<?php echo urlencode($property['id'] ?? uniqid()); ?>" class="property-btn">Ver Detalles</a>
                    </div>
                        </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>TellSol Real Estate</h4>
                <p>Tu socio de confianza en la Costa del Sol</p>
                <p>Especialistas en propiedades de lujo</p>
            </div>
            <div class="footer-section">
                <h4>Contacto</h4>
                <p>Email: info@thellsol.com</p>
                <p>Teléfono: +34 123 456 789</p>
                <p>WhatsApp: +34 123 456 789</p>
            </div>
            <div class="footer-section">
                <h4>Enlaces</h4>
                <a href="index.php">Inicio</a>
                <a href="comprar.php">Propiedades</a>
                <a href="contacto.html">Contacto</a>
                <a href="informacion-legal.html">Información Legal</a>
            </div>
        </div>
    </footer>

    <script>
        function openMobileMenu() {
          document.getElementById('mobileMenu').classList.add('open');
          document.getElementById('mobileMenuBg').classList.add('open');
        }
        function closeMobileMenu() {
          document.getElementById('mobileMenu').classList.remove('open');
          document.getElementById('mobileMenuBg').classList.remove('open');
        }
        
        function filterProperties() {
            const location = document.getElementById('location').value.toLowerCase();
            const type = document.getElementById('type').value;
            const minPrice = document.getElementById('min-price').value;
            const maxPrice = document.getElementById('max-price').value;
            const bedrooms = document.getElementById('bedrooms').value;
            
            const properties = document.querySelectorAll('.property-card');
            let visibleCount = 0;
            
            properties.forEach(property => {
                const propLocation = property.dataset.location;
                const propType = property.dataset.type;
                const propPrice = parseInt(property.dataset.price);
                const propBedrooms = parseInt(property.dataset.bedrooms);
                
                let show = true;
                
                if (location && propLocation !== location) show = false;
                if (type && propType !== type) show = false;
                if (minPrice && propPrice < parseInt(minPrice)) show = false;
                if (maxPrice && propPrice > parseInt(maxPrice)) show = false;
                if (bedrooms && propBedrooms < parseInt(bedrooms)) show = false;
                
                if (show) {
                    property.style.display = 'block';
                    visibleCount++;
                } else {
                    property.style.display = 'none';
                }
            });
            
            document.querySelector('.properties-count').textContent = `${visibleCount} propiedades encontradas`;
        }
    </script>
</body>
</html>
