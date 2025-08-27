<?php
// ELIMINAR ARCHIVOS SOBRANTES DE HOSTINGER
// Este archivo eliminará todos los archivos de prueba y sobrantes

echo "<h1>🗑️ ELIMINAR ARCHIVOS SOBRANTES DE HOSTINGER</h1>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
.container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
.success { color: green; font-weight: bold; }
.error { color: red; font-weight: bold; }
.warning { color: orange; font-weight: bold; }
.file-list { background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0; }
.btn { background: #dc3545; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 1.1rem; margin: 10px; }
.btn:hover { background: #c82333; }
.btn-safe { background: #28a745; }
.btn-safe:hover { background: #218838; }
</style>";

// Lista de archivos a eliminar (archivos sobrantes identificados en la imagen)
$archivosAEliminar = [
    // Archivos de prueba y soluciones anteriores
    'arreglar-index.php',
    'actualizar-todo.php', 
    'diagnostico-completo.php',
    'restaurar-paginas.php',
    'solucion-definitiva.php',
    'solucion-inmediata.php',
    'solucion-simple.php',
    'verificar-configuracion.php',
    'verificar-tabla.php',
    
    // Archivos de test
    'test-connection-complete.php',
    'test-dashboard-api.php',
    'test-dashboard-supabase.php',
    'test-final.html',
    'test-html.html',
    'test-simple.html',
    'test-supabase-connection.php',
    'test-supabase-simple.php',
    
    // Archivos de configuración antigua
    'supabase-config-correct.php',
    'supabase-connection.php',
    'supabase-js-connection.php',
    'new-config.php',
    
    // Archivos de propiedades antiguas
    'propiedades-dinamicas.php',
    
    // Archivos de limpieza (ya no necesarios)
    'limpiar-archivos.php',
    
    // Archivos backup
    'index-backup.php',
    
    // Archivos ZIP
    'thellsol-hostinguer-directo.zip',
    'thellsol-hostinguer-fix-me-please.zip',
    
    // Archivos markdown innecesarios
    'RESUMEN-SOLUCION-FINAL.md',
    'SOLUCION-COMPLETA-FINAL.md', 
    'SOLUCION-PROPIEDADES-DASHBOARD.md',
    'ESTADO-MIGRACION.md',
    'GUIA-CLIENTE-FINAL.md',
    'GUIA-DASHBOARD.md',
    'INSTRUCCIONES-FINALES.md',
    'RESUMEN-MIGRACION-FINAL.md',
    'SOLUCION-WEB-ONLINE.md',
    'supabase-setup.md',
    'vercel-deployment-guide.md',
    
    // Scripts innecesarios
    'deploy-to-vercel.sh',
    'migrate-complete.sh',
    'migrate-to-vercel-final.sh',
    'migrate-to-vercel.sh',
    'setup-database.sh',
    'setup-database.sql',
    'setup-supabase.sh',
    'start-local.sh',
    'start-test.sh',
    'start-web.sh',
    'start.sh',
    'serve-test.js',
    'servir-html-directo.js',
    'servir-html-local.js',
    'servir-html.js',
    'test-server.js',
    'server.config.js',
    'server.js',
    
    // Archivos de configuración innecesarios
    'vercel.json',
    'vercel-supabase.json',
    'postcss.config.js',
    'postcss.config.mjs',
    'next.config.js',
    'next-env.d.ts',
    'tsconfig.json',
    'tailwind.config.js',
    'eslint.config.mjs',
    'env.example'
];

// Archivos IMPORTANTES que NO se deben eliminar
$archivosImportantes = [
    'index.php',
    'comprar.php', 
    'admin-dashboard.php',
    'admin-login.php',
    'dashboard-api.php',
    'auth-config.php',
    'propiedad-detalles.php',
    'properties.json',
    'contacto.html',
    'informacion-legal.html',
    'politica-privacidad.html',
    'politica-cookies.html',
    'aviso-legal.html',
    'vender.html',
    'images/',
    'flags/',
    'docs/',
    'js/',
    'css/'
];

echo "<div class='container'>";

echo "<h2>📋 ARCHIVOS QUE SE VAN A ELIMINAR:</h2>";
echo "<div class='file-list'>";
echo "<h3>🗑️ Archivos de prueba y sobrantes (" . count($archivosAEliminar) . " archivos):</h3>";
echo "<ul>";
foreach ($archivosAEliminar as $archivo) {
    $existe = file_exists($archivo) ? "✅ Existe" : "❌ No existe";
    echo "<li>$archivo - $existe</li>";
}
echo "</ul>";
echo "</div>";

echo "<h2>✅ ARCHIVOS IMPORTANTES QUE SE MANTIENEN:</h2>";
echo "<div class='file-list'>";
echo "<ul>";
foreach ($archivosImportantes as $archivo) {
    echo "<li><strong>$archivo</strong></li>";
}
echo "</ul>";
echo "</div>";

if (isset($_GET['confirmar']) && $_GET['confirmar'] === 'ELIMINAR') {
    echo "<h2>🗑️ ELIMINANDO ARCHIVOS...</h2>";
    
    $eliminados = 0;
    $errores = 0;
    $noExisten = 0;
    
    foreach ($archivosAEliminar as $archivo) {
        if (file_exists($archivo)) {
            if (unlink($archivo)) {
                echo "<p class='success'>✅ Eliminado: $archivo</p>";
                $eliminados++;
            } else {
                echo "<p class='error'>❌ Error al eliminar: $archivo</p>";
                $errores++;
            }
        } else {
            echo "<p class='warning'>⚠️ No existe: $archivo</p>";
            $noExisten++;
        }
    }
    
    echo "<h3>📊 RESUMEN FINAL:</h3>";
    echo "<p><strong>✅ Archivos eliminados:</strong> $eliminados</p>";
    echo "<p><strong>⚠️ Archivos que no existían:</strong> $noExisten</p>";
    echo "<p><strong>❌ Errores:</strong> $errores</p>";
    
    if ($errores === 0) {
        echo "<p class='success' style='font-size: 1.3em;'>🎉 ¡LIMPIEZA COMPLETADA CON ÉXITO!</p>";
        echo "<p>Tu servidor ahora solo tiene los archivos necesarios para el funcionamiento de la web.</p>";
        
        echo "<h3>🔗 VERIFICAR FUNCIONAMIENTO:</h3>";
        echo "<ul>";
        echo "<li><a href='index.php' target='_blank'>🏠 Página principal</a></li>";
        echo "<li><a href='comprar.php' target='_blank'>🏘️ Página de propiedades</a></li>";
        echo "<li><a href='admin-login.php' target='_blank'>🔐 Dashboard admin</a></li>";
        echo "<li><a href='contacto.html' target='_blank'>📞 Página de contacto</a></li>";
        echo "</ul>";
        
        echo "<p style='margin-top: 30px;'><em>Puedes eliminar este archivo (eliminar-archivos-sobrantes.php) después de verificar que todo funciona correctamente.</em></p>";
    } else {
        echo "<p class='error' style='font-size: 1.3em;'>⚠️ Limpieza completada con algunos errores</p>";
    }
    
} else {
    echo "<h2>⚠️ CONFIRMACIÓN REQUERIDA</h2>";
    echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3>🚨 ADVERTENCIA IMPORTANTE:</h3>";
    echo "<p>Esta acción eliminará <strong>" . count($archivosAEliminar) . " archivos</strong> de forma permanente.</p>";
    echo "<p>Los archivos importantes para el funcionamiento de la web se mantendrán intactos.</p>";
    echo "<p><strong>¿Estás seguro de que quieres proceder?</strong></p>";
    echo "</div>";
    
    echo "<div style='text-align: center; margin: 30px 0;'>";
    echo "<a href='?confirmar=ELIMINAR' class='btn'>🗑️ SÍ, ELIMINAR ARCHIVOS SOBRANTES</a>";
    echo "<a href='index.php' class='btn btn-safe'>❌ CANCELAR Y VOLVER AL INICIO</a>";
    echo "</div>";
}

echo "</div>";
?>
