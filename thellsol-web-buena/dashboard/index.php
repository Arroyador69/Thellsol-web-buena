<?php
require_once '../config.php';

// Verificar autenticación
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Obtener estadísticas
$stmt = $pdo->query("SELECT COUNT(*) as total FROM properties");
$totalProperties = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM properties WHERE status = 'active'");
$activeProperties = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT AVG(price) as avg_price FROM properties WHERE status = 'active'");
$avgPrice = $stmt->fetch()['avg_price'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ThellSol Real Estate</title>
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
            <a href="../index.html" class="btn btn-success">
                <i class="fas fa-external-link-alt"></i> Ver Sitio Web
            </a>
        </div>

        <!-- Tabla de Propiedades -->
        <div class="properties-table">
            <div class="table-header">
                <i class="fas fa-home"></i> Gestión de Propiedades
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
                        <!-- Se llena con JavaScript -->
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
            <form id="propertyForm" enctype="multipart/form-data">
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
                    <label for="image">Imagen Principal</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
                
                <div class="form-group">
                    <label for="gallery">Galería de Imágenes (puedes seleccionar varias)</label>
                    <input type="file" id="gallery" name="gallery[]" accept="image/*" multiple>
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
        // Cargar propiedades al iniciar
        document.addEventListener('DOMContentLoaded', loadProperties);

        function loadProperties() {
            fetch('../api/properties.php')
                .then(response => response.json())
                .then(properties => {
                    const tbody = document.getElementById('propertiesTableBody');
                    tbody.innerHTML = '';
                    
                    properties.forEach(property => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>
                                <img src="../${property.image_url || 'images/placeholder.jpg'}" 
                                     alt="${property.title}" class="property-image">
                            </td>
                            <td><a href="property.php?id=${property.id}" target="_blank" style="color:#181e29;font-weight:600;text-decoration:underline;">${property.title}</a></td>
                            <td>${formatPrice(property.price)}€</td>
                            <td>${property.location}</td>
                            <td>${property.type}</td>
                            <td>
                                <span class="status-badge status-${property.status || 'active'}">
                                    ${property.status || 'active'}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-small btn-edit" onclick="editProperty(${property.id})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-small btn-delete" onclick="deleteProperty(${property.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error cargando propiedades:', error);
                });
        }

        function formatPrice(price) {
            return new Intl.NumberFormat('es-ES').format(price);
        }

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Nueva Propiedad';
            document.getElementById('propertyForm').reset();
            document.getElementById('propertyId').value = '';
            document.getElementById('propertyModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('propertyModal').style.display = 'none';
        }

        function editProperty(id) {
            fetch(`../api/properties.php?id=${id}`)
                .then(response => response.json())
                .then(property => {
                    document.getElementById('modalTitle').textContent = 'Editar Propiedad';
                    document.getElementById('propertyId').value = property.id;
                    document.getElementById('title').value = property.title;
                    document.getElementById('price').value = property.price;
                    document.getElementById('type').value = property.type;
                    document.getElementById('location').value = property.location;
                    document.getElementById('bedrooms').value = property.bedrooms;
                    document.getElementById('bathrooms').value = property.bathrooms;
                    document.getElementById('area').value = property.area;
                    document.getElementById('description').value = property.description;
                    
                    // Limpiar checkboxes
                    document.querySelectorAll('input[name="features[]"]').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    
                    // Marcar características existentes
                    if (property.features) {
                        property.features.forEach(feature => {
                            const checkbox = document.querySelector(`input[value="${feature.feature_name}"]`);
                            if (checkbox) checkbox.checked = true;
                        });
                    }
                    
                    document.getElementById('propertyModal').style.display = 'block';
                });
        }

        function deleteProperty(id) {
            if (confirm('¿Estás seguro de que quieres eliminar esta propiedad?')) {
                fetch(`../api/properties.php?id=${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadProperties();
                        alert('Propiedad eliminada correctamente');
                    }
                })
                .catch(error => {
                    console.error('Error eliminando propiedad:', error);
                    alert('Error al eliminar la propiedad');
                });
            }
        }

        // Manejar envío del formulario
        document.getElementById('propertyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const id = document.getElementById('propertyId').value;
            const method = id ? 'PUT' : 'POST';
            
            fetch('../api/properties.php', {
                method: method,
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal();
                    loadProperties();
                    alert(id ? 'Propiedad actualizada correctamente' : 'Propiedad creada correctamente');
                } else {
                    alert('Error al guardar la propiedad');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar la propiedad');
            });
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