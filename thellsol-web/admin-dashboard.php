<?php
require_once 'auth-config.php';
$current_user = require_auth();

// Sistema JSON LOCAL
$propertiesFile = "properties.json";

// Manejar acciones POST
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    // Crear propiedad
    if ($action === 'create_property') {
        // Cargar propiedades existentes
        $properties = [];
        if (file_exists($propertiesFile)) {
            $content = file_get_contents($propertiesFile);
            $properties = json_decode($content, true) ?: [];
        }
        
        // Crear nueva propiedad
        $newProperty = [
            'id' => time(), // ID único basado en timestamp
            'title' => $_POST['title'] ?? '',
            'price' => (int)($_POST['price'] ?? 0),
            'location' => $_POST['location'] ?? '',
            'type' => $_POST['type'] ?? '',
            'bedrooms' => (int)($_POST['bedrooms'] ?? 0),
            'bathrooms' => (int)($_POST['bathrooms'] ?? 0),
            'surface' => (int)($_POST['surface'] ?? 0),
            'description' => $_POST['description'] ?? '',
            'images' => array_filter(explode(',', $_POST['images'] ?? '')),
            'status' => 'active',
            'createdAt' => date('Y-m-d H:i:s'),
            'createdBy' => $current_user['name']
        ];
        
        $properties[] = $newProperty;
        
        // Guardar en JSON
        if (file_put_contents($propertiesFile, json_encode($properties, JSON_PRETTY_PRINT))) {
            $message = '<div class="alert alert-success">✅ Propiedad creada exitosamente!</div>';
        } else {
            $message = '<div class="alert alert-error">❌ Error al guardar la propiedad.</div>';
        }
    }
    
    // Eliminar propiedad
    if ($action === 'delete_property') {
        $propertyId = $_POST['property_id'] ?? '';
        if (!empty($propertyId)) {
            $properties = [];
            if (file_exists($propertiesFile)) {
                $content = file_get_contents($propertiesFile);
                $properties = json_decode($content, true) ?: [];
            }
            
            // Filtrar propiedades (eliminar la seleccionada)
            $properties = array_filter($properties, function($prop) use ($propertyId) {
                return $prop['id'] != $propertyId;
            });
            
            // Reindexar array
            $properties = array_values($properties);
            
            if (file_put_contents($propertiesFile, json_encode($properties, JSON_PRETTY_PRINT))) {
                $message = '<div class="alert alert-success">✅ Propiedad eliminada exitosamente!</div>';
            } else {
                $message = '<div class="alert alert-error">❌ Error al eliminar la propiedad.</div>';
            }
        }
    }
}

// Cargar propiedades para mostrar
$properties = [];
if (file_exists($propertiesFile)) {
    $content = file_get_contents($propertiesFile);
    $properties = json_decode($content, true) ?: [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - TellSol Real Estate</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }
        
        .header {
            background: rgba(255, 255, 255, 0.95);
            padding: 1rem 2rem;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            color: #333;
            font-size: 1.8rem;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-details p {
            margin: 0;
            line-height: 1.2;
        }
        
        .user-name {
            font-weight: bold;
            color: #333;
        }
        
        .user-role {
            color: #666;
            font-size: 0.9rem;
        }
        
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background 0.3s;
        }
        
        .logout-btn:hover {
            background: #c82333;
        }
        
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .card h2 {
            color: #333;
            margin-bottom: 1.5rem;
            border-bottom: 3px solid #667eea;
            padding-bottom: 0.5rem;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #555;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn {
            background: #667eea;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #5a6fd8;
        }
        
        .btn-danger {
            background: #dc3545;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .properties-list {
            grid-column: 1 / -1;
        }
        
        .property-item {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .property-info h4 {
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .property-meta {
            color: #666;
            font-size: 0.9rem;
        }
        
        .property-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        
        .empty-state h3 {
            margin-bottom: 1rem;
        }
        
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .property-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Panel de Administración</h1>
        <div class="user-info">
            <div class="user-details">
                <p class="user-name"><?php echo htmlspecialchars($current_user['name']); ?></p>
                <p class="user-role"><?php echo htmlspecialchars($current_user['role']); ?> - <?php echo htmlspecialchars($current_user['email']); ?></p>
            </div>
            <a href="admin-login.php?action=logout" class="logout-btn">🚪 Cerrar Sesión</a>
        </div>
    </div>

    <div class="container">
        <?php echo $message; ?>
        
        <div class="dashboard-grid">
            <!-- Formulario para crear propiedades -->
            <div class="card">
                <h2>🏠 Crear Nueva Propiedad</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="create_property">
                    
                    <div class="form-group">
                        <label for="title">Título de la Propiedad:</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Precio (€):</label>
                        <input type="number" id="price" name="price" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="location">Ubicación:</label>
                        <input type="text" id="location" name="location" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="type">Tipo de Propiedad:</label>
                        <select id="type" name="type" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="apartamento">Apartamento</option>
                            <option value="villa">Villa</option>
                            <option value="casa">Casa</option>
                            <option value="penthouse">Penthouse</option>
                            <option value="estudio">Estudio</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="bedrooms">Dormitorios:</label>
                        <input type="number" id="bedrooms" name="bedrooms" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="bathrooms">Baños:</label>
                        <input type="number" id="bathrooms" name="bathrooms" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="surface">Superficie (m²):</label>
                        <input type="number" id="surface" name="surface" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Descripción:</label>
                        <textarea id="description" name="description" rows="4"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="images">URLs de Imágenes (separadas por comas):</label>
                        <textarea id="images" name="images" rows="3" placeholder="https://ejemplo.com/imagen1.jpg, https://ejemplo.com/imagen2.jpg"></textarea>
                    </div>
                    
                    <button type="submit" class="btn">🏠 Crear Propiedad</button>
                </form>
            </div>
            
            <!-- Estadísticas -->
            <div class="card">
                <h2>📈 Estadísticas</h2>
                <div style="text-align: center;">
                    <div style="font-size: 3rem; color: #667eea; margin-bottom: 1rem;">
                        <?php echo count($properties); ?>
                    </div>
                    <p style="font-size: 1.2rem; color: #666;">
                        Propiedades Publicadas
                    </p>
                    <div style="margin-top: 2rem;">
                        <a href="index.php" target="_blank" class="btn" style="display: inline-block; text-decoration: none;">
                            🌐 Ver Sitio Web
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Lista de propiedades -->
            <div class="card properties-list">
                <h2>🏘️ Propiedades Publicadas (<?php echo count($properties); ?>)</h2>
                
                <?php if (empty($properties)): ?>
                    <div class="empty-state">
                        <h3>📝 No hay propiedades publicadas</h3>
                        <p>Las propiedades que crees aparecerán aquí y se publicarán automáticamente en la web.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($properties as $property): ?>
                        <div class="property-item">
                            <div class="property-info">
                                <h4><?php echo htmlspecialchars($property['title']); ?></h4>
                                <div class="property-meta">
                                    <strong>€<?php echo number_format($property['price']); ?></strong> - 
                                    <?php echo htmlspecialchars($property['location']); ?> - 
                                    <?php echo htmlspecialchars($property['type']); ?> - 
                                    <?php echo $property['bedrooms']; ?> dorm, <?php echo $property['bathrooms']; ?> baños, <?php echo $property['surface']; ?>m²
                                    <br>
                                    <small>Creado: <?php echo $property['createdAt']; ?> por <?php echo htmlspecialchars($property['createdBy']); ?></small>
                                </div>
                            </div>
                            <div class="property-actions">
                                <a href="propiedad-detalles.php?id=<?php echo $property['id']; ?>" target="_blank" class="btn" style="text-decoration: none;">👁️ Ver</a>
                                <form method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta propiedad?')">
                                    <input type="hidden" name="action" value="delete_property">
                                    <input type="hidden" name="property_id" value="<?php echo $property['id']; ?>">
                                    <button type="submit" class="btn btn-danger">🗑️ Eliminar</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
