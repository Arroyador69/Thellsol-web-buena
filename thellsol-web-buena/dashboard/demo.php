<?php
// Simular sesión de administrador para la demo
session_start();
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_username'] = 'admin';

// Datos de ejemplo para la demostración
$demoProperties = [
    [
        'id' => 1,
        'title' => 'Apartamento de lujo en Fuengirola',
        'price' => 350000,
        'type' => 'apartment',
        'location' => 'fuengirola',
        'bedrooms' => 3,
        'bathrooms' => 2,
        'area' => 120.50,
        'description' => 'Hermoso apartamento con vistas al mar, completamente equipado y en excelente ubicación.',
        'image_url' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        'status' => 'active',
        'features' => ['pool', 'garden', 'airConditioning', 'elevator']
    ],
    [
        'id' => 2,
        'title' => 'Villa moderna en Benalmádena',
        'price' => 850000,
        'type' => 'villa',
        'location' => 'benalmadena',
        'bedrooms' => 4,
        'bathrooms' => 3,
        'area' => 280.00,
        'description' => 'Villa de lujo con piscina privada, jardín y garaje para 2 coches.',
        'image_url' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        'status' => 'active',
        'features' => ['pool', 'garden', 'garage', 'terrace', 'airConditioning']
    ],
    [
        'id' => 3,
        'title' => 'Casa adosada en Mijas',
        'price' => 420000,
        'type' => 'house',
        'location' => 'mijas',
        'bedrooms' => 3,
        'bathrooms' => 2,
        'area' => 150.00,
        'description' => 'Casa adosada en urbanización tranquila con piscina comunitaria.',
        'image_url' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        'status' => 'active',
        'features' => ['garden', 'terrace', 'heating']
    ],
    [
        'id' => 4,
        'title' => 'Ático con vistas al mar',
        'price' => 580000,
        'type' => 'penthouse',
        'location' => 'torremolinos',
        'bedrooms' => 2,
        'bathrooms' => 2,
        'area' => 95.00,
        'description' => 'Ático de lujo con terraza privada y vistas panorámicas al mar.',
        'image_url' => 'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        'status' => 'active',
        'features' => ['terrace', 'airConditioning', 'seaView', 'elevator']
    ],
    [
        'id' => 5,
        'title' => 'Chalet en Torreblanca',
        'price' => 520000,
        'type' => 'house',
        'location' => 'torreblanca',
        'bedrooms' => 4,
        'bathrooms' => 3,
        'area' => 200.00,
        'description' => 'Chalet independiente con jardín privado y garaje.',
        'image_url' => 'https://images.unsplash.com/photo-1600566752355-35792bedcfea?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        'status' => 'active',
        'features' => ['garden', 'garage', 'heating', 'security']
    ],
    [
        'id' => 6,
        'title' => 'Apartamento en Nueva Andalucía',
        'price' => 450000,
        'type' => 'apartment',
        'location' => 'nuevaAndalucia',
        'bedrooms' => 2,
        'bathrooms' => 2,
        'area' => 85.00,
        'description' => 'Apartamento moderno en zona exclusiva cerca del golf.',
        'image_url' => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        'status' => 'inactive',
        'features' => ['terrace', 'airConditioning', 'elevator']
    ]
];

// Calcular estadísticas
$totalProperties = count($demoProperties);
$activeProperties = count(array_filter($demoProperties, function($p) { return $p['status'] === 'active'; }));
$avgPrice = array_sum(array_column($demoProperties, 'price')) / count($demoProperties);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Demo - ThellSol Real Estate</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="../logo-thellsol copia.png" type="image/png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Cormorant Garamond', serif;
            background: #f5f7fa;
            color: #333;
        }
        
        .demo-banner {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: #fff;
            text-align: center;
            padding: 12px;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header {
            background: #181e29;
            color: #fff;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: 700;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logout-btn {
            background: #c33;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: 700;
            color: #181e29;
            margin-bottom: 8px;
        }
        
        .stat-label {
            color: #666;
            font-size: 16px;
        }
        
        .actions {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: #181e29;
            color: #fff;
        }
        
        .btn-primary:hover {
            background: #232a3a;
        }
        
        .btn-success {
            background: #28a745;
            color: #fff;
        }
        
        .btn-success:hover {
            background: #218838;
        }
        
        .btn-demo {
            background: #ff6b6b;
            color: #fff;
        }
        
        .btn-demo:hover {
            background: #ee5a24;
        }
        
        .properties-table {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .table-header {
            background: #181e29;
            color: #fff;
            padding: 20px;
            font-weight: 700;
            font-size: 18px;
        }
        
        .table-content {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        
        .property-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        
        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        .btn-edit {
            background: #ffc107;
            color: #000;
        }
        
        .btn-delete {
            background: #dc3545;
            color: #fff;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        
        .modal-content {
            background: #fff;
            margin: 50px auto;
            padding: 30px;
            border-radius: 12px;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .close {
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
        }
        
        .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }
        
        .feature-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .demo-info {
            background: #e3f2fd;
            border: 1px solid #2196f3;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
        }
        
        .demo-info h3 {
            color: #1976d2;
            margin-bottom: 8px;
        }
        
        .demo-info p {
            color: #424242;
            margin-bottom: 4px;
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .table-content {
                font-size: 14px;
            }
            
            th, td {
                padding: 10px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="demo-banner">
        🎯 DEMOSTRACIÓN - Dashboard ThellSol Real Estate
    </div>
    
    <div class="header">
        <div class="header-content">
            <div class="logo">ThellSol Dashboard</div>
            <div class="user-info">
                <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="demo-info">
            <h3>📋 Información de la Demostración</h3>
            <p><strong>Esta es una versión de demostración</strong> con datos de ejemplo para mostrar las funcionalidades del dashboard.</p>
            <p><strong>Credenciales de prueba:</strong> admin / thellsol2024!</p>
            <p><strong>Funcionalidades disponibles:</strong> Ver estadísticas, explorar propiedades, simular edición</p>
        </div>

        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $totalProperties; ?></div>
                <div class="stat-label">Total Propiedades</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $activeProperties; ?></div>
                <div class="stat-label">Propiedades Activas</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo number_format($avgPrice, 0, ',', '.'); ?>€</div>
                <div class="stat-label">Precio Promedio</div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="actions">
            <button class="btn btn-primary" onclick="openAddModal()">
                <i class="fas fa-plus"></i> Nueva Propiedad
            </button>
            <button class="btn btn-success" onclick="showImagesDemo()">
                <i class="fas fa-images"></i> Gestión de Imágenes
            </button>
            <a href="../index.html" class="btn btn-demo">
                <i class="fas fa-external-link-alt"></i> Ver Sitio Web
            </a>
        </div>

        <!-- Tabla de Propiedades -->
        <div class="properties-table">
            <div class="table-header">
                <i class="fas fa-home"></i> Gestión de Propiedades (Demo)
            </div>
            <div class="table-content">
                <table id="propertiesTable">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Título</th>
                            <th>Precio</th>
                            <th>Ubicación</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="propertiesTableBody">
                        <?php foreach ($demoProperties as $property): ?>
                        <tr>
                            <td>
                                <img src="<?php echo htmlspecialchars($property['image_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($property['title']); ?>" 
                                     class="property-image">
                            </td>
                            <td><?php echo htmlspecialchars($property['title']); ?></td>
                            <td><?php echo number_format($property['price'], 0, ',', '.'); ?>€</td>
                            <td><?php echo htmlspecialchars($property['location']); ?></td>
                            <td><?php echo htmlspecialchars($property['type']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $property['status']; ?>">
                                    <?php echo $property['status']; ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-small btn-edit" onclick="editProperty(<?php echo $property['id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-small btn-delete" onclick="deleteProperty(<?php echo $property['id']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para agregar/editar propiedad -->
    <div id="propertyModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Nueva Propiedad</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="propertyForm">
                <input type="hidden" id="propertyId" name="id">
                
                <div class="form-group">
                    <label for="title">Título</label>
                    <input type="text" id="title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="price">Precio (€)</label>
                    <input type="number" id="price" name="price" required>
                </div>
                
                <div class="form-group">
                    <label for="type">Tipo de Propiedad</label>
                    <select id="type" name="type" required>
                        <option value="">Seleccionar tipo</option>
                        <option value="apartment">Apartamento</option>
                        <option value="villa">Villa</option>
                        <option value="house">Casa</option>
                        <option value="penthouse">Ático</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="location">Ubicación</label>
                    <select id="location" name="location" required>
                        <option value="">Seleccionar ubicación</option>
                        <option value="fuengirola">Fuengirola</option>
                        <option value="mijas">Mijas</option>
                        <option value="benalmadena">Benalmádena</option>
                        <option value="torreblanca">Torreblanca</option>
                        <option value="torremolinos">Torremolinos</option>
                        <option value="riviera">Riviera del Sol</option>
                        <option value="calahonda">Calahonda</option>
                        <option value="marbella">Marbella</option>
                        <option value="nuevaAndalucia">Nueva Andalucía</option>
                        <option value="malaga">Málaga</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="bedrooms">Dormitorios</label>
                    <input type="number" id="bedrooms" name="bedrooms" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="bathrooms">Baños</label>
                    <input type="number" id="bathrooms" name="bathrooms" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="area">Área (m²)</label>
                    <input type="number" id="area" name="area" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                
                <div class="form-group">
                    <label>Características</label>
                    <div class="features-grid">
                        <div class="feature-checkbox">
                            <input type="checkbox" id="pool" name="features[]" value="pool">
                            <label for="pool">Piscina</label>
                        </div>
                        <div class="feature-checkbox">
                            <input type="checkbox" id="garden" name="features[]" value="garden">
                            <label for="garden">Jardín</label>
                        </div>
                        <div class="feature-checkbox">
                            <input type="checkbox" id="garage" name="features[]" value="garage">
                            <label for="garage">Garaje</label>
                        </div>
                        <div class="feature-checkbox">
                            <input type="checkbox" id="terrace" name="features[]" value="terrace">
                            <label for="terrace">Terraza</label>
                        </div>
                        <div class="feature-checkbox">
                            <input type="checkbox" id="airConditioning" name="features[]" value="airConditioning">
                            <label for="airConditioning">Aire Acondicionado</label>
                        </div>
                        <div class="feature-checkbox">
                            <input type="checkbox" id="heating" name="features[]" value="heating">
                            <label for="heating">Calefacción</label>
                        </div>
                        <div class="feature-checkbox">
                            <input type="checkbox" id="elevator" name="features[]" value="elevator">
                            <label for="elevator">Ascensor</label>
                        </div>
                        <div class="feature-checkbox">
                            <input type="checkbox" id="security" name="features[]" value="security">
                            <label for="security">Seguridad 24h</label>
                        </div>
                        <div class="feature-checkbox">
                            <input type="checkbox" id="seaView" name="features[]" value="seaView">
                            <label for="seaView">Vistas al mar</label>
                        </div>
                        <div class="feature-checkbox">
                            <input type="checkbox" id="furnished" name="features[]" value="furnished">
                            <label for="furnished">Mobiliario incluido</label>
                        </div>
                    </div>
                </div>
                
                <div class="actions">
                    <button type="submit" class="btn btn-primary">Guardar Propiedad</button>
                    <button type="button" class="btn btn-success" onclick="closeModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function formatPrice(price) {
            return new Intl.NumberFormat('es-ES').format(price);
        }

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Nueva Propiedad (Demo)';
            document.getElementById('propertyForm').reset();
            document.getElementById('propertyId').value = '';
            document.getElementById('propertyModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('propertyModal').style.display = 'none';
        }

        function editProperty(id) {
            alert('🔄 Función de edición en demostración\n\nEn la versión completa, aquí se cargarían los datos de la propiedad para editar.');
            document.getElementById('modalTitle').textContent = 'Editar Propiedad (Demo)';
            document.getElementById('propertyId').value = id;
            document.getElementById('propertyModal').style.display = 'block';
        }

        function deleteProperty(id) {
            if (confirm('🗑️ ¿Estás seguro de que quieres eliminar esta propiedad?\n\n(Esta es una demostración - no se eliminará nada)')) {
                alert('✅ Propiedad eliminada correctamente\n\nEn la versión completa, la propiedad se eliminaría de la base de datos.');
            }
        }

        function showImagesDemo() {
            alert('📸 Gestión de Imágenes\n\nEn la versión completa, aquí podrías:\n• Subir múltiples imágenes\n• Arrastrar y soltar archivos\n• Ver vista previa\n• Eliminar imágenes\n• Copiar URLs');
        }

        // Manejar envío del formulario
        document.getElementById('propertyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('✅ Propiedad guardada correctamente\n\nEn la versión completa, la propiedad se guardaría en la base de datos.');
            closeModal();
        });

        // Cerrar modal al hacer clic fuera
        window.onclick = function(event) {
            const modal = document.getElementById('propertyModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html> 