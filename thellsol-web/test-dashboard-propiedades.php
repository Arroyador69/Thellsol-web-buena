<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Propiedades Dashboard - ThellSol</title>
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
        .status.warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        .instructions {
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
        <h1>Test Propiedades Dashboard - ThellSol</h1>
        
        <div class="instructions">
            <h3>📋 Instrucciones para añadir propiedades:</h3>
            <ol>
                <li>Ve al archivo <strong>propiedades-dashboard.php</strong></li>
                <li>Añade las propiedades que crees en el dashboard</li>
                <li>Sube el archivo actualizado al servidor</li>
                <li>Las propiedades aparecerán automáticamente en la web</li>
            </ol>
        </div>
        
        <div class="status warning">
            ⚠️ Actualmente no hay propiedades del dashboard configuradas
        </div>
        
        <div class="cards">
            <h2>Propiedades del Dashboard</h2>
            <div id="properties-list">
                <?php
                require_once 'propiedades-dashboard.php';
                $properties = getDashboardProperties();
                displayDashboardProperties($properties);
                ?>
            </div>
        </div>
        
        <div style="margin-top: 30px; padding: 20px; background: #f0f0f0; border-radius: 8px;">
            <h3>Información del Test:</h3>
            <p><strong>Total de propiedades del dashboard:</strong> <?php echo count($properties); ?></p>
            <p><strong>Estado:</strong> 
                <?php if (count($properties) > 0): ?>
                    ✅ Propiedades configuradas
                <?php else: ?>
                    ⚠️ No hay propiedades configuradas
                <?php endif; ?>
            </p>
            <p><strong>Método:</strong> Archivo estático actualizable manualmente</p>
        </div>
    </div>
</body>
</html>
