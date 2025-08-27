<?php
// Página de login para el dashboard admin
require_once 'auth-config.php';

$error_message = '';
$success_message = '';

// Manejar logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout_user();
    $success_message = 'Has cerrado sesión correctamente.';
}

// Verificar si ya está logueado
$current_user = is_logged_in();
if ($current_user) {
    header('Location: admin-dashboard.php');
    exit();
}

// Procesar formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error_message = 'Por favor, completa todos los campos.';
    } else {
        $user = verify_user($email, $password);
        if ($user) {
            login_user($user);
            header('Location: admin-dashboard.php');
            exit();
        } else {
            $error_message = 'Credenciales incorrectas. Verifica tu email y contraseña.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Panel de Administración | ThellSol</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="logo-thellsol copia.png" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
            margin: 20px;
        }
        
        .login-header {
            background: #181e29;
            color: white;
            padding: 30px 40px;
            text-align: center;
        }
        
        .login-logo {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            background: white;
            object-fit: contain;
            margin: 0 auto 15px;
            display: block;
        }
        
        .login-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0 0 5px 0;
        }
        
        .login-subtitle {
            font-size: 0.9rem;
            opacity: 0.8;
            margin: 0;
        }
        
        .login-form {
            padding: 40px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .login-button {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
            margin-top: 10px;
        }
        
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .alert-error {
            background: #fee;
            border: 1px solid #fcc;
            color: #c33;
        }
        
        .alert-success {
            background: #efe;
            border: 1px solid #cfc;
            color: #393;
        }
        
        .login-footer {
            background: #f8f9fa;
            padding: 20px 40px;
            text-align: center;
            border-top: 1px solid #e1e5e9;
        }
        
        .back-link {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        .login-info {
            background: #f8f9fa;
            border: 1px solid #e1e5e9;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
            color: #666;
        }
        
        .login-info h4 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 0.9rem;
        }
        
        .credentials-info p {
            margin: 5px 0;
        }
        
        @media (max-width: 480px) {
            .login-container {
                margin: 10px;
            }
            
            .login-header,
            .login-form,
            .login-footer {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="./images/logo-thellsol.png" alt="TellSol Logo" class="login-logo">
            <h1 class="login-title">Panel de Administración</h1>
            <p class="login-subtitle">ThellSol Real Estate</p>
        </div>
        
        <div class="login-form">
            <?php if ($error_message): ?>
                <div class="alert alert-error">
                    <strong>Error:</strong> <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <strong>Éxito:</strong> <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>
            
            <div class="login-info">
                <h4>🏢 Panel de Administración</h4>
                <p>Acceso exclusivo para administradores autorizados de TellSol Real Estate</p>
            </div>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="tu@email.com"
                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                        required
                    >
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Tu contraseña"
                        required
                    >
                </div>
                
                <button type="submit" class="login-button">
                    🔐 Iniciar Sesión
                </button>
            </form>
        </div>
        
        <div class="login-footer">
            <a href="index.php" class="back-link">← Volver a la página principal</a>
        </div>
    </div>
</body>
</html>
