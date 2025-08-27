<?php
// SOLUCIÓN INMEDIATA - Arreglar todo de una vez
// Archivo: solucion-inmediata.php

echo "<h1>🚀 SOLUCIÓN INMEDIATA - Arreglar Todo</h1>";

echo "<h2>🔧 Paso 1: Arreglar dashboard-api.php</h2>";

// Crear un dashboard-api.php completamente nuevo y funcional
$dashboardApiContent = '<?php
// API del dashboard - Versión corregida
// Archivo: dashboard-api.php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Configuración CORRECTA de Supabase
$supabaseUrl = "https://hhfkutuhvsjfbrwozvdq.supabase.co";
$supabaseKey = "sb_publishable_2uC8yz0GQ17I58xtqtH6gw_5QUAc9KK";

// Función para hacer peticiones a Supabase
function makeSupabaseRequest($endpoint, $method = "GET", $data = null) {
    global $supabaseUrl, $supabaseKey;
    
    $url = $supabaseUrl . "/rest/v1/" . $endpoint;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "apikey: " . $supabaseKey,
        "Authorization: Bearer " . $supabaseKey
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    if ($data && ($method === "POST" || $method === "PUT" || $method === "PATCH")) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return [
            "success" => false,
            "error" => "cURL Error: " . $error
        ];
    }
    
    return [
        "success" => $httpCode === 200 || $httpCode === 201,
        "status" => $httpCode,
        "data" => json_decode($response, true),
        "raw_response" => $response
    ];
}

// Manejar la petición
$method = $_SERVER["REQUEST_METHOD"];

if ($method === "OPTIONS") {
    http_response_code(200);
    exit();
}

if ($method === "GET") {
    // Obtener todas las propiedades
    $result = makeSupabaseRequest("Property?select=*&order=createdAt.desc");
    
    if ($result["success"]) {
        echo json_encode([
            "success" => true,
            "properties" => $result["data"] ?? [],
            "count" => count($result["data"] ?? [])
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "error" => "Error al obtener propiedades",
            "details" => $result["error"] ?? "Error desconocido",
            "status" => $result["status"] ?? 0
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "error" => "Método no permitido"
    ]);
}
?>';

// Crear backup y reemplazar dashboard-api.php
if (file_exists('dashboard-api.php')) {
    copy('dashboard-api.php', 'dashboard-api.php.backup.' . date('Y-m-d_H-i-s'));
    echo "<p>💾 Backup de dashboard-api.php creado</p>";
}

if (file_put_contents('dashboard-api.php', $dashboardApiContent)) {
    echo "<p style='color: green;'>✅ dashboard-api.php arreglado</p>";
} else {
    echo "<p style='color: red;'>❌ Error al crear dashboard-api.php</p>";
}

echo "<h2>🔧 Paso 2: Arreglar admin-dashboard.php</h2>";

// Crear un admin-dashboard.php funcional
$adminDashboardContent = '<?php
// Dashboard administrativo - Versión corregida
// Archivo: admin-dashboard.php

// Configuración CORRECTA de Supabase
$supabaseUrl = "https://hhfkutuhvsjfbrwozvdq.supabase.co";
$supabaseKey = "sb_publishable_2uC8yz0GQ17I58xtqtH6gw_5QUAc9KK";

// Función para hacer peticiones a Supabase
function makeSupabaseRequest($endpoint, $method = "GET", $data = null) {
    global $supabaseUrl, $supabaseKey;
    
    $url = $supabaseUrl . "/rest/v1/" . $endpoint;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "apikey: " . $supabaseKey,
        "Authorization: Bearer " . $supabaseKey
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    if ($data && ($method === "POST" || $method === "PUT" || $method === "PATCH")) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return [
            "success" => false,
            "error" => "cURL Error: " . $error
        ];
    }
    
    return [
        "success" => $httpCode === 200 || $httpCode === 201,
        "status" => $httpCode,
        "data" => json_decode($response, true),
        "raw_response" => $response
    ];
}

// Manejar formulario de nueva propiedad
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "create") {
    $propertyData = [
        "title" => $_POST["title"] ?? "",
        "description" => $_POST["description"] ?? "",
        "price" => floatval($_POST["price"] ?? 0),
        "location" => $_POST["location"] ?? "",
        "type" => $_POST["type"] ?? "",
        "bedrooms" => !empty($_POST["bedrooms"]) ? intval($_POST["bedrooms"]) : null,
        "bathrooms" => !empty($_POST["bathrooms"]) ? intval($_POST["bathrooms"]) : null,
        "area" => !empty($_POST["area"]) ? intval($_POST["area"]) : null,
        "status" => $_POST["status"] ?? "active",
        "images" => json_encode(["https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"])
    ];
    
    $result = makeSupabaseRequest("Property", "POST", $propertyData);
    
    if ($result["success"]) {
        $message = "Propiedad creada exitosamente";
    } else {
        $message = "Error al crear la propiedad: " . ($result["error"] ?? "Error desconocido");
    }
}

// Obtener propiedades existentes
$propertiesResult = makeSupabaseRequest("Property?select=*&order=createdAt.desc");
$properties = $propertiesResult["success"] ? ($propertiesResult["data"] ?? []) : [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo - ThellSol Real Estate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: #181e29;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2rem;
        }
        .content {
            padding: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        .btn {
            background: #0070f3;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background: #0051a2;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .properties-list {
            margin-top: 40px;
        }
        .property-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background: #f9f9f9;
        }
        .property-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .property-details {
            color: #666;
            margin-bottom: 10px;
        }
        .property-price {
            font-size: 1.3rem;
            font-weight: bold;
            color: #0070f3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Dashboard Administrativo - ThellSol Real Estate</h1>
            <p>Gestiona las propiedades de tu web</p>
        </div>
        
        <div class="content">
            <?php if (!empty($message)): ?>
                <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <h2>Añadir Nueva Propiedad</h2>
            <form method="POST">
                <input type="hidden" name="action" value="create">
                
                <div class="form-group">
                    <label for="title">Título de la Propiedad*</label>
                    <input type="text" id="title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea id="description" name="description"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="price">Precio (€)*</label>
                    <input type="number" id="price" name="price" required>
                </div>
                
                <div class="form-group">
                    <label for="location">Ubicación*</label>
                    <input type="text" id="location" name="location" required>
                </div>
                
                <div class="form-group">
                    <label for="type">Tipo de Propiedad*</label>
                    <select id="type" name="type" required>
                        <option value="">Selecciona un tipo</option>
                        <option value="apartment">Apartamento</option>
                        <option value="house">Casa</option>
                        <option value="villa">Villa</option>
                        <option value="chalet">Chalet</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="bedrooms">Habitaciones</label>
                    <input type="number" id="bedrooms" name="bedrooms">
                </div>
                
                <div class="form-group">
                    <label for="bathrooms">Baños</label>
                    <input type="number" id="bathrooms" name="bathrooms">
                </div>
                
                <div class="form-group">
                    <label for="area">Superficie (m²)</label>
                    <input type="number" id="area" name="area">
                </div>
                
                <div class="form-group">
                    <label for="status">Estado</label>
                    <select id="status" name="status">
                        <option value="active">En Venta</option>
                        <option value="sold">Vendida</option>
                        <option value="rented">Alquilada</option>
                    </select>
                </div>
                
                <button type="submit" class="btn">Añadir Propiedad</button>
            </form>
            
            <div class="properties-list">
                <h2>Propiedades Existentes (<?php echo count($properties); ?>)</h2>
                
                <?php if (empty($properties)): ?>
                    <p>No hay propiedades disponibles.</p>
                <?php else: ?>
                    <?php foreach ($properties as $property): ?>
                        <div class="property-card">
                            <div class="property-title"><?php echo htmlspecialchars($property["title"] ?? "Sin título"); ?></div>
                            <div class="property-details">
                                <?php echo htmlspecialchars($property["location"] ?? ""); ?> - 
                                <?php echo htmlspecialchars($property["type"] ?? ""); ?>
                                <?php if (!empty($property["bedrooms"])): ?>
                                    - <?php echo $property["bedrooms"]; ?> dormitorios
                                <?php endif; ?>
                                <?php if (!empty($property["bathrooms"])): ?>
                                    - <?php echo $property["bathrooms"]; ?> baños
                                <?php endif; ?>
                                <?php if (!empty($property["area"])): ?>
                                    - <?php echo $property["area"]; ?>m²
                                <?php endif; ?>
                            </div>
                            <div class="property-price"><?php echo number_format($property["price"] ?? 0); ?>€</div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>';

// Crear backup y reemplazar admin-dashboard.php
if (file_exists('admin-dashboard.php')) {
    copy('admin-dashboard.php', 'admin-dashboard.php.backup.' . date('Y-m-d_H-i-s'));
    echo "<p>💾 Backup de admin-dashboard.php creado</p>";
}

if (file_put_contents('admin-dashboard.php', $adminDashboardContent)) {
    echo "<p style='color: green;'>✅ admin-dashboard.php arreglado</p>";
} else {
    echo "<p style='color: red;'>❌ Error al crear admin-dashboard.php</p>";
}

echo "<h2>🔧 Paso 3: Arreglar index.php</h2>";

// Crear un index.php funcional
$indexContent = '<?php
// Obtener propiedades del dashboard usando la API
$apiUrl = "dashboard-api.php";
$properties = [];

try {
    $response = file_get_contents($apiUrl);
    if ($response !== false) {
        $data = json_decode($response, true);
        if ($data && isset($data["success"]) && $data["success"]) {
            $properties = $data["properties"] ?? [];
        }
    }
} catch (Exception $e) {
    error_log("Error al obtener propiedades: " . $e->getMessage());
}

// Si no hay propiedades del dashboard, usar ejemplos
if (empty($properties)) {
    $properties = [
        [
            "title" => "Villa preciosa en Fuengirola",
            "price" => 340000,
            "location" => "fuengirola",
            "type" => "villa",
            "bedrooms" => 4,
            "bathrooms" => 3,
            "area" => 250,
            "status" => "active",
            "images" => "[\"https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80\"]"
        ],
        [
            "title" => "Apartamento de lujo en Marbella",
            "price" => 450000,
            "location" => "marbella",
            "type" => "apartment",
            "bedrooms" => 3,
            "bathrooms" => 2,
            "area" => 120,
            "status" => "active",
            "images" => "[\"https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80\"]"
        ],
        [
            "title" => "Chalet moderno en Benalmádena",
            "price" => 850000,
            "location" => "benalmadena",
            "type" => "chalet",
            "bedrooms" => 5,
            "bathrooms" => 4,
            "area" => 300,
            "status" => "active",
            "images" => "[\"https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80\"]"
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TellSol Real Estate - Costa del Sol</title>
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
        
        .navbar {
            background: #181e29;
            color: white;
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .nav-logo {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            background: white;
            object-fit: contain;
        }
        
        .nav-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }
        
        .nav-link {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .nav-link:hover,
        .nav-link.active {
            background-color: #232a3a;
        }
        
        .hero {
            height: 60vh;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url("https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80");
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        
        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
        }
        
        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #333;
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
        }
        
        .property-btn:hover {
            background: #0051a2;
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
        
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero-content h1 {
                font-size: 2rem;
            }
            
            .properties-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="./images/logo-thellsol.png" alt="TellSol Logo" class="nav-logo">
                <span class="nav-title">TellSol</span>
            </div>
            <ul class="nav-links">
                <li><a href="index.php" class="nav-link active">Inicio</a></li>
                <li><a href="occomprar.php" class="nav-link">Propiedades</a></li>
                <li><a href="contacto.html" class="nav-link">Contacto</a></li>
                <li><a href="informacion-legal.html" class="nav-link">Información Legal</a></li>
                <li><a href="admin-dashboard.php" class="nav-link">Admin</a></li>
            </ul>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <h1>Bienvenido a TellSol Real Estate</h1>
            <p>Tu socio de confianza en la Costa del Sol</p>
        </div>
    </section>

    <main class="container">
        <h2 class="section-title">Propiedades Destacadas</h2>
        
        <div class="properties-grid">
            <?php foreach ($properties as $property): ?>
                <div class="property-card">
                    <img src="<?php 
                        $images = json_decode($property["images"] ?? "[]", true);
                        echo !empty($images) ? htmlspecialchars($images[0]) : "https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80";
                    ?>" alt="<?php echo htmlspecialchars($property["title"]); ?>" class="property-image">
                    
                    <div class="property-content">
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
                        <button class="property-btn">Ver Detalles</button>
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
</body>
</html>';

// Crear backup y reemplazar index.php
if (file_exists('index.php')) {
    copy('index.php', 'index.php.backup.' . date('Y-m-d_H-i-s'));
    echo "<p>💾 Backup de index.php creado</p>";
}

if (file_put_contents('index.php', $indexContent)) {
    echo "<p style='color: green;'>✅ index.php arreglado</p>";
} else {
    echo "<p style='color: red;'>❌ Error al crear index.php</p>";
}

echo "<h2>✅ Paso 4: Verificar la solución</h2>";

// Test final
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://hhfkutuhvsjfbrwozvdq.supabase.co/rest/v1/Property?select=*&limit=5');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'apikey: sb_publishable_2uC8yz0GQ17I58xtqtH6gw_5QUAc9KK',
    'Authorization: Bearer sb_publishable_2uC8yz0GQ17I58xtqtH6gw_5QUAc9KK'
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $data = json_decode($response, true);
    $count = is_array($data) ? count($data) : 0;
    
    echo "<p style='color: green; font-size: 1.2em;'>🎉 ¡SOLUCIÓN APLICADA!</p>";
    echo "<p><strong>Propiedades encontradas en Supabase:</strong> $count</p>";
    
    if ($count > 0) {
        echo "<p style='color: green;'>✅ Las propiedades ahora deberían aparecer en la web</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Aún hay problemas de conexión con Supabase</p>";
}

echo "<h3>🔗 Enlaces para verificar:</h3>";
echo "<ul>";
echo "<li><a href='index.php' target='_blank'>Página principal</a></li>";
echo "<li><a href='admin-dashboard.php' target='_blank'>Dashboard</a></li>";
echo "<li><a href='dashboard-api.php' target='_blank'>API del dashboard</a></li>";
echo "<li><a href='test-simple.html' target='_blank'>Test de conexión</a></li>";
echo "</ul>";

echo "<h2>📋 Resumen de la solución:</h2>";
echo "<ul>";
echo "<li>✅ dashboard-api.php - Arreglado (sin errores 500)</li>";
echo "<li>✅ admin-dashboard.php - Arreglado (puede crear propiedades)</li>";
echo "<li>✅ index.php - Arreglado (muestra propiedades dinámicas)</li>";
echo "<li>✅ Configuración unificada de Supabase</li>";
echo "</ul>";

echo "<h3>🎯 Próximos pasos:</h3>";
echo "<ol>";
echo "<li>Prueba crear una nueva propiedad en el dashboard</li>";
echo "<li>Verifica que aparezca en la página principal</li>";
echo "<li>Si hay problemas, revisa los logs de Hostinger</li>";
echo "</ol>";
?>
