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
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css">
    <script src="./js/translations.js"></script>
    <script src="./js/language-selector.js"></script>
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
        .main-content {
            display: flex;
            max-width: 1300px;
            margin: 0 auto;
            padding: 48px 0 0 0;
            min-height: 80vh;
        }
        .filtros {
            width: 340px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 28px 24px 24px 24px;
            margin-right: 48px;
            height: fit-content;
            border: 1px solid #eaeaea;
        }
        .filtros label {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }
        .filtros select, .filtros input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            font-size: 15px;
            background-color: #f8f8f8;
            transition: all 0.3s ease;
        }
        .filtros select:focus, .filtros input[type="text"]:focus {
            border-color: #0a53e4;
            box-shadow: 0 0 0 2px rgba(10, 83, 228, 0.1);
            outline: none;
        }
        .filtros-row {
            display: flex;
            gap: 12px;
        }
        .filtros-row > div {
            flex: 1;
        }
        .filtros-btn {
            background: #0a53e4;
            color: #fff;
            font-weight: 600;
            margin-top: 24px;
            padding: 14px;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .filtros-btn:hover {
            background: #003fa3;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(10, 83, 228, 0.2);
        }
        .filtros-mas {
            background: #f0f0f0;
            color: #333;
            font-size: 15px;
            margin-bottom: 12px;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            border: 1px solid #e0e0e0;
        }
        .filtros-mas:hover {
            background: #e8e8e8;
            transform: translateY(-1px);
        }
        .resultados {
            flex: 1;
            padding-top: 12px;
        }
        .resultados-titulo {
            font-size: 2.3rem;
            font-weight: bold;
            margin-bottom: 32px;
        }
        .cards {
            display: flex;
            gap: 24px;
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
            margin-bottom: 24px;
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
        @media (max-width: 1100px) {
            .main-content { flex-direction: column; }
            .filtros { margin-right: 0; margin-bottom: 32px; }
        }
        @media (max-width: 900px) {
            .main-content {
                flex-direction: column !important;
                gap: 16px;
                padding: 24px 0 0 0;
                max-width: 100vw;
            }
            .filtros {
                max-width: 98vw !important;
                margin: 0 auto 18px auto !important;
                padding: 18px 6px 18px 6px !important;
            }
            .cards {
                flex-direction: column;
                align-items: center;
                gap: 16px;
            }
            .card {
                width: 98vw;
                max-width: 350px;
            }
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
            .main-content {
                padding: 10px 0 0 0;
                gap: 8px;
            }
            .filtros {
                padding: 10px 2vw 10px 2vw !important;
                border-radius: 8px;
            }
            .resultados-titulo {
                font-size: 1.3rem;
                margin-bottom: 18px;
            }
            .card {
                width: 98vw;
                max-width: 98vw;
                min-width: unset;
                padding: 0 0 12px 0;
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
        <div class="navbar-left">
            <img src="./images/logo-thellsol.png" alt="Logo" class="navbar-logo">
            <span class="navbar-title">TellSol</span>
        </div>
        <div class="navbar-center">
            <a href="index.php" class="navbar-link">Inicio</a>
            <div class="dropdown">
                <a href="#" class="navbar-link active">Propiedades</a>
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

    <div class="main-content">
        <!-- Filtros -->
        <div class="filtros">
            <h3>Filtros de Búsqueda</h3>
            <div class="filtros-row">
                <div>
                    <label for="zona">Zona</label>
                    <select id="zona">
                        <option value="">Todas las zonas</option>
                        <option value="fuengirola">Fuengirola</option>
                        <option value="mijas">Mijas</option>
                        <option value="benalmadena">Benalmádena</option>
                        <option value="marbella">Marbella</option>
                        <option value="malaga">Málaga</option>
                    </select>
                </div>
                <div>
                    <label for="tipo">Tipo</label>
                    <select id="tipo">
                        <option value="">Todos los tipos</option>
                        <option value="apartamento">Apartamento</option>
                        <option value="villa">Villa</option>
                        <option value="chalet">Chalet</option>
                        <option value="casa-adosada">Casa Adosada</option>
                    </select>
                </div>
            </div>
            <div class="filtros-row">
                <div>
                    <label for="precio">Precio</label>
                    <select id="precio">
                        <option value="">Todos los precios</option>
                        <option value="100000-200000">100.000€ - 200.000€</option>
                        <option value="200000-300000">200.000€ - 300.000€</option>
                        <option value="300000-400000">300.000€ - 400.000€</option>
                        <option value="400000+">Más de 400.000€</option>
                    </select>
                </div>
                <div>
                    <label for="dormitorios">Dormitorios</label>
                    <select id="dormitorios">
                        <option value="">Cualquier número</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5+">5+</option>
                    </select>
                </div>
            </div>
            <button class="filtros-btn">BUSCAR PROPIEDADES</button>
        </div>

        <!-- Resultados -->
        <div class="resultados">
            <h1 class="resultados-titulo">Propiedades Disponibles</h1>
            <div class="cards">
                <?php if (!empty($properties)): ?>
                    <?php foreach ($properties as $property): ?>
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
        </div>
    </div>

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
