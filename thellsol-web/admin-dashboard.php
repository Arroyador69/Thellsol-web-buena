<?php
require_once 'supabase-connection.php';

// Manejar formularios
$message = handlePropertyForm();

// Obtener propiedades
$supabase = new SupabaseConnection();
$propertiesResult = $supabase->getProperties();
$properties = $propertiesResult['data'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ThellSol Real Estate</title>
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
        .btn-delete {
            background: #dc3545;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        .btn-delete:hover {
            background: #c82333;
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
        .property-price {
            color: #0070f3;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .property-location {
            color: #666;
            margin-bottom: 10px;
        }
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .form-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
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
            <?php if ($message): ?>
                <div class="<?php echo $message['success'] ? 'success-message' : 'error-message'; ?>">
                    <?php echo htmlspecialchars($message['message']); ?>
                </div>
            <?php endif; ?>
            
            <div class="form-section">
                <h2>Añadir Nueva Propiedad</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="create">
                    
                    <div class="form-group">
                        <label for="title">Título de la Propiedad *</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <textarea id="description" name="description"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Precio (€) *</label>
                        <input type="number" id="price" name="price" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="location">Ubicación *</label>
                        <input type="text" id="location" name="location" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="type">Tipo de Propiedad *</label>
                        <select id="type" name="type" required>
                            <option value="">Selecciona un tipo</option>
                            <option value="Apartamento">Apartamento</option>
                            <option value="Villa">Villa</option>
                            <option value="Casa">Casa</option>
                            <option value="Ático">Ático</option>
                            <option value="Terreno">Terreno</option>
                            <option value="Local Comercial">Local Comercial</option>
                            <option value="Oficina">Oficina</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="bedrooms">Habitaciones</label>
                        <input type="number" id="bedrooms" name="bedrooms" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="bathrooms">Baños</label>
                        <input type="number" id="bathrooms" name="bathrooms" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="area">Superficie (m²)</label>
                        <input type="number" id="area" name="area" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Estado</label>
                        <select id="status" name="status">
                            <option value="for-sale">En Venta</option>
                            <option value="for-rent">En Alquiler</option>
                            <option value="sold">Vendida</option>
                            <option value="rented">Alquilada</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Añadir Propiedad</button>
                </form>
            </div>
            
            <div class="properties-list">
                <h2>Propiedades Existentes (<?php echo count($properties); ?>)</h2>
                <?php if (empty($properties)): ?>
                    <p>No hay propiedades registradas.</p>
                <?php else: ?>
                    <?php foreach ($properties as $property): ?>
                        <div class="property-card">
                            <div class="property-title"><?php echo htmlspecialchars($property['title']); ?></div>
                            <div class="property-price"><?php echo number_format($property['price']); ?>€</div>
                            <div class="property-location"><?php echo htmlspecialchars($property['location']); ?> - <?php echo htmlspecialchars($property['type']); ?></div>
                            <div>
                                Habitaciones: <?php echo $property['bedrooms'] ?? 'N/A'; ?> | 
                                Baños: <?php echo $property['bathrooms'] ?? 'N/A'; ?> | 
                                Superficie: <?php echo $property['area'] ?? 'N/A'; ?>m²
                            </div>
                            <div>Estado: <?php echo htmlspecialchars($property['status']); ?></div>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $property['id']; ?>">
                                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de que quieres eliminar esta propiedad?')">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
