<?php
echo "=== VERIFICACIÓN DE ESTRUCTURA THELLSOL ===\n\n";

// Verificar archivos PHP principales
$archivos_php = [
    'index.php',
    'comprar.php', 
    'comprar-dinamico.php',
    'propiedades-dinamicas.php',
    'admin-dashboard.php',
    'supabase-connection.php'
];

echo "📁 ARCHIVOS PHP PRINCIPALES:\n";
foreach ($archivos_php as $archivo) {
    if (file_exists($archivo)) {
        echo "✅ $archivo - EXISTE\n";
    } else {
        echo "❌ $archivo - NO EXISTE\n";
    }
}

// Verificar archivos HTML de redirección
echo "\n📁 ARCHIVOS HTML DE REDIRECCIÓN:\n";
$archivos_html = ['index.html', 'comprar.html'];
foreach ($archivos_html as $archivo) {
    if (file_exists($archivo)) {
        echo "✅ $archivo - EXISTE\n";
    } else {
        echo "❌ $archivo - NO EXISTE\n";
    }
}

// Verificar archivo .htaccess
echo "\n📁 ARCHIVO .HTACCESS:\n";
if (file_exists('.htaccess')) {
    echo "✅ .htaccess - EXISTE\n";
} else {
    echo "❌ .htaccess - NO EXISTE\n";
}

// Verificar directorio de imágenes
echo "\n📁 DIRECTORIO DE IMÁGENES:\n";
if (is_dir('images')) {
    echo "✅ images/ - EXISTE\n";
    $imagenes = glob('images/*');
    echo "   📸 Imágenes encontradas: " . count($imagenes) . "\n";
} else {
    echo "❌ images/ - NO EXISTE\n";
}

echo "\n=== VERIFICACIÓN COMPLETADA ===\n";
echo "\n🎯 PRÓXIMOS PASOS:\n";
echo "1. Subir todos los archivos al servidor web\n";
echo "2. Verificar que las URLs funcionen:\n";
echo "   - thellsol.com/index.html → redirige a index.php\n";
echo "   - thellsol.com/comprar.html → redirige a comprar.php\n";
echo "3. Verificar que las propiedades se muestren desde Supabase\n";
echo "4. Probar el panel de administración\n";
?>
