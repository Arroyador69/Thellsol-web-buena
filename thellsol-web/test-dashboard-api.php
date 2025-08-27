<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Dashboard API - ThellSol</title>
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
        .status.loading {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .info-box {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test Dashboard API - ThellSol</h1>
        
        <div class="info-box">
            <h3>🎯 Conexión Directa con el Dashboard</h3>
            <p>Esta API conecta directamente con tu dashboard en <strong>thellsol.com/dashboard/index.php</strong></p>
            <p>Si funciona, verás las propiedades que creas en el dashboard automáticamente.</p>
        </div>
        
        <div id="status" class="status loading">
            🔄 Conectando con el dashboard...
        </div>
        
        <div id="properties-container" class="cards" style="display:none;">
            <h2>Propiedades del Dashboard</h2>
            <div id="properties-list"></div>
        </div>
        
        <div id="error-container" style="display:none;">
            <h2>Error de Conexión</h2>
            <p id="error-message"></p>
        </div>
    </div>

    <script>
    async function loadPropertiesFromDashboard() {
        try {
            const response = await fetch('dashboard-api.php');
            const data = await response.json();
            
            const statusDiv = document.getElementById('status');
            const propertiesContainer = document.getElementById('properties-container');
            const errorContainer = document.getElementById('error-container');
            
            if (data.success) {
                statusDiv.className = 'status success';
                statusDiv.innerHTML = `✅ Conexión exitosa - ${data.count} propiedades encontradas en el dashboard`;
                
                propertiesContainer.style.display = 'block';
                displayProperties(data.properties);
            } else {
                statusDiv.className = 'status error';
                statusDiv.innerHTML = `❌ Error: ${data.error}`;
                
                errorContainer.style.display = 'block';
                document.getElementById('error-message').innerHTML = data.details || 'Error desconocido';
            }
        } catch (error) {
            const statusDiv = document.getElementById('status');
            statusDiv.className = 'status error';
            statusDiv.innerHTML = `❌ Error de conexión: ${error.message}`;
            
            document.getElementById('error-container').style.display = 'block';
            document.getElementById('error-message').innerHTML = error.message;
        }
    }
    
    function displayProperties(properties) {
        const container = document.getElementById('properties-list');
        
        if (properties.length === 0) {
            container.innerHTML = '<p>No hay propiedades en el dashboard.</p>';
            return;
        }
        
        let html = '';
        properties.forEach(property => {
            const images = property.images ? JSON.parse(property.images) : [];
            const mainImage = images.length > 0 ? images[0] : 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
            
            const desc = [];
            if (property.bedrooms) desc.push(property.bedrooms + ' dormitorios');
            if (property.bathrooms) desc.push(property.bathrooms + ' baños');
            if (property.area) desc.push(property.area + 'm²');
            
            html += `
            <div class="card">
                <img src="${mainImage}" class="card-img" alt="${property.title}">
                <div class="card-body">
                    <h3 class="card-title">${property.title}</h3>
                    <p class="card-zona">${property.location}</p>
                    <p class="card-desc">${desc.join(', ')}</p>
                    <p class="card-precio">${new Intl.NumberFormat('es-ES').format(property.price)}€</p>
                    <button class="card-btn">Ver Detalles</button>
                </div>
            </div>
            `;
        });
        
        container.innerHTML = html;
    }
    
    // Cargar propiedades cuando se carga la página
    document.addEventListener('DOMContentLoaded', loadPropertiesFromDashboard);
    </script>
</body>
</html>
