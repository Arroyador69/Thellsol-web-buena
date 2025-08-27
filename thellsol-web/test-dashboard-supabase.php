<?php
// Test para verificar que el dashboard guarda correctamente en Supabase
// Archivo: test-dashboard-supabase.php

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
        'success' => $httpCode === 200 || $httpCode === 201,
        'status' => $httpCode,
        'data' => json_decode($response, true),
        'raw_response' => $response
    ];
}

// Función para crear una propiedad de prueba
function createTestProperty() {
    $testProperty = [
        'title' => 'Propiedad de Prueba - ' . date('Y-m-d H:i:s'),
        'description' => 'Esta es una propiedad de prueba creada automáticamente para verificar la conexión con Supabase',
        'price' => 250000,
        'location' => 'fuengirola',
        'type' => 'villa',
        'bedrooms' => 3,
        'bathrooms' => 2,
        'area' => 150,
        'status' => 'for-sale'
    ];
    
    return makeSupabaseRequest('Property', 'POST', $testProperty);
}

// Procesar formulario si se envía
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create_test':
                $result = createTestProperty();
                if ($result['success']) {
                    $message = '✅ Propiedad de prueba creada correctamente en Supabase';
                } else {
                    $message = '❌ Error al crear propiedad de prueba: ' . ($result['error'] ?? 'Error desconocido');
                }
                break;
                
            case 'delete_test':
                if (isset($_POST['id'])) {
                    $result = makeSupabaseRequest('Property?id=eq.' . $_POST['id'], 'DELETE');
                    if ($result['success']) {
                        $message = '✅ Propiedad eliminada correctamente';
                    } else {
                        $message = '❌ Error al eliminar propiedad';
                    }
                }
                break;
        }
    }
}

// Obtener propiedades de Supabase
$properties = [];
$connectionStatus = '';

try {
    $result = makeSupabaseRequest('Property?select=*&order=createdAt.desc');
    
    if ($result['success'] && is_array($result['data'])) {
        $properties = $result['data'];
        $connectionStatus = 'success';
    } else {
        $connectionStatus = 'error';
        $errorMessage = $result['error'] ?? 'Error desconocido';
    }
} catch (Exception $e) {
    $connectionStatus = 'error';
    $errorMessage = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Dashboard + Supabase - ThellSol</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .status {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: bold;
        }
        .status.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .status.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px #0001;
            width: 270px;
            padding: 0 0 18px 0;
            margin: 12px;
            display: inline-block;
            vertical-align: top;
        }
        .card-img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }
        .card-body {
            padding: 12px 18px 0 18px;
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
        }
        .cards {
            text-align: center;
        }
        .info-box {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .debug-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-family: monospace;
            font-size: 12px;
        }
        .btn {
            background: #0070f3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background: #0051a2;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .btn-success {
            background: #28a745;
        }
        .btn-success:hover {
            background: #218838;
        }
        .message {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: bold;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Test Dashboard + Supabase - ThellSol</h1>
        
        <div class="info-box">
            <h3>🎯 Objetivo</h3>
            <p>Esta página verifica que el dashboard guarde correctamente las propiedades en Supabase y que la web las lea correctamente.</p>
            <p><strong>Flujo completo:</strong> Dashboard → Supabase → Página Web</p>
        </div>
        
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, '✅') !== false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($connectionStatus === 'success'): ?>
            <div class="status success">
                ✅ Conexión exitosa con Supabase - <?php echo count($properties); ?> propiedades encontradas
            </div>
            
            <div style="text-align: center; margin: 20px 0;">
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="create_test">
                    <button type="submit" class="btn btn-success">➕ Crear Propiedad de Prueba</button>
                </form>
                <a href="admin-dashboard.php" class="btn">📊 Ir al Dashboard</a>
                <a href="comprar.php" class="btn">🏠 Ver Página de Comprar</a>
            </div>
            
            <div class="cards">
                <h2>🏠 Propiedades en Supabase</h2>
                <?php if (empty($properties)): ?>
                    <p>No hay propiedades en Supabase.</p>
                <?php else: ?>
                    <?php foreach ($properties as $property): ?>
                        <div class="card">
                            <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="card-img" alt="<?php echo htmlspecialchars($property['title']); ?>">
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
                                <p style="font-size: 0.8rem; color: #666;">Estado: <?php echo htmlspecialchars($property['status']); ?></p>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="delete_test">
                                    <input type="hidden" name="id" value="<?php echo $property['id']; ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar esta propiedad?')">🗑️ Eliminar</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <div class="debug-info">
                <h4>🔍 Información de Debug:</h4>
                <p><strong>URL Supabase:</strong> <?php echo $supabaseUrl; ?></p>
                <p><strong>Total propiedades:</strong> <?php echo count($properties); ?></p>
                <p><strong>Estado:</strong> Conexión exitosa</p>
                <p><strong>Propiedades 'for-sale':</strong> <?php echo count(array_filter($properties, function($p) { return $p['status'] === 'for-sale'; })); ?></p>
            </div>
            
        <?php else: ?>
            <div class="status error">
                ❌ Error de conexión con Supabase
            </div>
            
            <div class="debug-info">
                <h4>🔍 Información de Debug:</h4>
                <p><strong>URL Supabase:</strong> <?php echo $supabaseUrl; ?></p>
                <p><strong>Error:</strong> <?php echo isset($errorMessage) ? $errorMessage : 'Error desconocido'; ?></p>
                <p><strong>Estado:</strong> Conexión fallida</p>
            </div>
            
            <div class="info-box">
                <h3>🔧 Soluciones posibles:</h3>
                <ul>
                    <li>Verificar que las credenciales de Supabase sean correctas</li>
                    <li>Comprobar que la tabla 'Property' existe en Supabase</li>
                    <li>Verificar que el servidor tenga acceso a internet</li>
                    <li>Revisar los logs del servidor para más detalles</li>
                </ul>
            </div>
        <?php endif; ?>
        
        <div style="margin-top: 30px; text-align: center;">
            <a href="test-supabase-connection.php" class="btn">🔗 Test Conexión Simple</a>
            <a href="test-dashboard-api.php" class="btn">📡 Test API Dashboard</a>
            <a href="admin-dashboard.php" class="btn">📊 Dashboard Admin</a>
        </div>
    </div>
</body>
</html>
