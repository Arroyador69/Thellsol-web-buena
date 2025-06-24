<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Credenciales de demostración
    if ($username === 'admin' && $password === 'thellsol2024!') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: demo.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Demo - Dashboard ThellSol</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Cormorant Garamond', serif;
            background: linear-gradient(135deg, #181e29 0%, #232a3a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .demo-banner {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: #fff;
            text-align: center;
            padding: 8px;
            font-weight: 600;
            font-size: 14px;
        }
        
        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            margin-top: 40px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            border-radius: 12px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
            color: #181e29;
        }
        
        h1 {
            color: #181e29;
            margin-bottom: 8px;
            font-size: 28px;
            font-weight: 700;
        }
        
        .demo-subtitle {
            color: #666;
            margin-bottom: 32px;
            font-size: 16px;
        }
        
        .demo-credentials {
            background: #e3f2fd;
            border: 1px solid #2196f3;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
            text-align: left;
        }
        
        .demo-credentials h3 {
            color: #1976d2;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .demo-credentials p {
            color: #424242;
            margin-bottom: 4px;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }
        
        input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: #181e29;
        }
        
        .btn {
            width: 100%;
            padding: 14px;
            background: #181e29;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #232a3a;
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #fcc;
        }
        
        .back-link {
            margin-top: 24px;
            display: block;
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }
        
        .back-link:hover {
            color: #181e29;
        }
        
        .features-list {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 16px;
            margin-top: 24px;
            text-align: left;
        }
        
        .features-list h4 {
            color: #333;
            margin-bottom: 12px;
            font-size: 16px;
        }
        
        .features-list ul {
            list-style: none;
            padding: 0;
        }
        
        .features-list li {
            color: #666;
            margin-bottom: 6px;
            font-size: 14px;
            padding-left: 20px;
            position: relative;
        }
        
        .features-list li:before {
            content: '✅';
            position: absolute;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="demo-banner">
        🎯 DEMOSTRACIÓN - Dashboard ThellSol Real Estate
    </div>
    
    <div class="login-container">
        <div class="logo">TS</div>
        <h1>Dashboard ThellSol</h1>
        <div class="demo-subtitle">Versión de Demostración</div>
        
        <div class="demo-credentials">
            <h3>🔑 Credenciales de Prueba</h3>
            <p><strong>Usuario:</strong> admin</p>
            <p><strong>Contraseña:</strong> thellsol2024!</p>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" value="admin" required>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" value="thellsol2024!" required>
            </div>
            
            <button type="submit" class="btn">Acceder al Dashboard</button>
        </form>
        
        <div class="features-list">
            <h4>🚀 Funcionalidades de la Demo</h4>
            <ul>
                <li>Estadísticas en tiempo real</li>
                <li>Gestión de propiedades</li>
                <li>Subida de imágenes</li>
                <li>Interfaz responsive</li>
                <li>Sistema de autenticación</li>
                <li>Datos de ejemplo incluidos</li>
            </ul>
        </div>
        
        <a href="../index.html" class="back-link">← Volver al sitio web</a>
    </div>
</body>
</html> 