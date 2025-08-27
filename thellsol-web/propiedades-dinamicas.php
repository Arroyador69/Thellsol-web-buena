<?php
// Configuración CORRECTA de Supabase
$supabaseUrl = 'https://hhfkutuhvsjfbrwozvdq.supabase.co';
$supabaseKey = 'sb_publishable_2uC8yz0GQ17I58xtqtH6gw_5QUAc9KK';

// Función para hacer peticiones a Supabase usando cURL
function makeSupabaseRequest($endpoint, $method = 'GET', $data = null) {
    global $supabaseUrl, $supabaseKey;
    
    $url = $supabaseUrl . '/rest/v1/' . $endpoint;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'apikey: ' . $supabaseKey,
        'Authorization: Bearer ' . $supabaseKey
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    if ($data && ($method === 'POST' || $method === 'PUT' || $method === 'PATCH')) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return [
            'success' => false,
            'error' => 'cURL Error: ' . $error
        ];
    }
    
    return [
        'success' => $httpCode === 200,
        'status' => $httpCode,
        'data' => json_decode($response, true),
        'raw_response' => $response
    ];
}

// Obtener propiedades directamente de Supabase
$properties = [];

try {
    $result = makeSupabaseRequest('Property?select=*&order=createdAt.desc');
    
    if ($result['success'] && is_array($result['data'])) {
        $properties = $result['data'];
    }
} catch (Exception $e) {
    // Error silencioso, usar array vacío
    $properties = [];
}

// Filtrar solo propiedades en venta (como las guarda el dashboard)
$propertiesActive = array_filter($properties, function($property) {
    return $property['status'] === 'for-sale';
});
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propiedades - ThellSol Real Estate</title>
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
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .page-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 40px;
            color: #181e29;
        }
        .properties-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }
        .property-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .property-card:hover {
            transform: translateY(-5px);
        }
        .property-image {
            width: 100%;
            height: 250px;
            background: linear-gradient(45deg, #f0f0f0, #e0e0e0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 1.2rem;
        }
        .property-content {
            padding: 20px;
        }
        .property-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #181e29;
        }
        .property-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0070f3;
            margin-bottom: 15px;
        }
        .property-location {
            color: #666;
            margin-bottom: 10px;
            font-size: 1rem;
        }
        .property-details {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: #555;
        }
        .property-detail {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .property-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-for-sale {
            background: #d4edda;
            color: #155724;
        }
        .status-for-rent {
            background: #fff3cd;
            color: #856404;
        }
        .btn-contact {
            background: #0070f3;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            display: inline-block;
            font-weight: bold;
            transition: background 0.2s;
        }
        .btn-contact:hover {
            background: #0051a2;
        }
        .no-properties {
            text-align: center;
            padding: 60px 20px;
            color: #666;
            font-size: 1.2rem;
        }
        .footer {
            background: #181e29;
            color: #fff;
            padding: 40px 20px;
            margin-top: 60px;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <img src="./images/logo-thellsol.png" alt="Logo Thellsol" class="navbar-logo" />
            <a href="index.html" class="navbar-link">Inicio</a>
            <a href="propiedades-dinamicas.php" class="navbar-link active">Propiedades</a>
        </div>
        <div class="navbar-center">
            <span class="navbar-title">ThellSol Real Estate</span>
        </div>
        <div class="navbar-right">
            <a href="informacion-legal.html" class="navbar-link">Información Legal</a>
            <a href="contacto.html" class="navbar-link">Contacto</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="page-title">Nuestras Propiedades</h1>
        
        <?php if (empty($propertiesActive)): ?>
            <div class="no-properties">
                <h2>No hay propiedades disponibles en este momento</h2>
                <p>Pronto añadiremos nuevas propiedades. ¡Mantente atento!</p>
                <a href="contacto.html" class="btn-contact">Contactar</a>
            </div>
        <?php else: ?>
            <div class="properties-grid">
                <?php foreach ($propertiesActive as $property): ?>
                    <div class="property-card">
                        <div class="property-image">
                            <?php if (!empty($property['images'])): ?>
                                <img src="<?php echo htmlspecialchars($property['images']); ?>" alt="<?php echo htmlspecialchars($property['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <span>Imagen no disponible</span>
                            <?php endif; ?>
                        </div>
                        <div class="property-content">
                            <h3 class="property-title"><?php echo htmlspecialchars($property['title']); ?></h3>
                            <div class="property-price"><?php echo number_format($property['price']); ?>€</div>
                            <div class="property-location"><?php echo htmlspecialchars($property['location']); ?> - <?php echo htmlspecialchars($property['type']); ?></div>
                            
                            <div class="property-details">
                                <?php if ($property['bedrooms']): ?>
                                    <div class="property-detail">
                                        <span>🛏️</span> <?php echo $property['bedrooms']; ?> hab.
                                    </div>
                                <?php endif; ?>
                                <?php if ($property['bathrooms']): ?>
                                    <div class="property-detail">
                                        <span>🚿</span> <?php echo $property['bathrooms']; ?> baños
                                    </div>
                                <?php endif; ?>
                                <?php if ($property['area']): ?>
                                    <div class="property-detail">
                                        <span>📐</span> <?php echo $property['area']; ?>m²
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="property-status status-<?php echo $property['status']; ?>">
                                <?php 
                                switch($property['status']) {
                                    case 'for-sale': echo 'En Venta'; break;
                                    case 'for-rent': echo 'En Alquiler'; break;
                                    case 'sold': echo 'Vendida'; break;
                                    case 'rented': echo 'Alquilada'; break;
                                    default: echo $property['status'];
                                }
                                ?>
                            </div>
                            
                            <?php if (!empty($property['description'])): ?>
                                <p style="margin: 15px 0; color: #666; font-size: 0.9rem;">
                                    <?php echo htmlspecialchars(substr($property['description'], 0, 100)); ?>...
                                </p>
                            <?php endif; ?>
                            
                            <a href="https://wa.me/34676335313?text=Hola, me interesa la propiedad: <?php echo urlencode($property['title']); ?>" 
                               class="btn-contact" target="_blank">
                                Contactar por WhatsApp
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <p><b>Andre Richard Tell</b> - ThellSol Real Estate</p>
            <p>Fuengirola 29640, Málaga, Spain</p>
            <p>andre@thellsol.com | +34 676 335 313</p>
        </div>
    </footer>
</body>
</html>
