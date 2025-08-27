<?php
// LIMPIAR ARCHIVOS DE PRUEBA - Eliminar archivos innecesarios
// Archivo: limpiar-archivos.php

echo "<h1>🧹 LIMPIAR ARCHIVOS DE PRUEBA</h1>";

echo "<h2>📋 Archivos que se van a ELIMINAR:</h2>";

// Lista de archivos a eliminar
$archivosAEliminar = [
    // Archivos de prueba
    'test-html.html',
    'test-simple.html',
    'test-final.html',
    'test-hard-test.html',
    'test-connection.html',
    'test-connection-complete.php',
    'test-dashboard-supabase.php',
    'test-propiedades-actuales.php',
    'test-supabase-con-nection.php',
    'test-supabase-fixed.php',
    'test-supabase-simple-api.php',
    'test-supabase-local.php',
    
    // Archivos de solución anteriores
    'solucion-simple.php',
    'solucion-inmediata.php',
    
    // Archivos de diagnóstico
    'diagnostico-completo.php',
    'verificar-configuracion.php',
    'verificar-tabla.php',
    'actualizar-todo.php',
    'arreglar-index.php',
    'restaurar-paginas.php',
    
    // Archivos de Supabase (ya no necesarios)
    'supabase-config-correct.php',
    'supabase-connection.php',
    'supabase-js-connection.php',
    'new-config.php',
    
    // Archivos de propiedades dinámicas (reemplazados)
    'propiedades-dinamicas.php',
    
    // Archivos ZIP
    'thellsol-hostinguer-directo.zip',
    'thellsol-hostinguer-fix-me-please.zip'
];

echo "<ul>";
foreach ($archivosAEliminar as $archivo) {
    echo "<li>❌ $archivo</li>";
}
echo "</ul>";

echo "<h2>📋 Archivos de BACKUP que se van a ELIMINAR:</h2>";

// Buscar archivos de backup
$archivosBackup = [];
$archivos = scandir('.');

foreach ($archivos as $archivo) {
    if (strpos($archivo, '.backup.') !== false) {
        $archivosBackup[] = $archivo;
    }
}

if (empty($archivosBackup)) {
    echo "<p>✅ No hay archivos de backup para eliminar</p>";
} else {
    echo "<ul>";
    foreach ($archivosBackup as $archivo) {
        echo "<li>❌ $archivo</li>";
    }
    echo "</ul>";
}

echo "<h2>🔧 ARCHIVOS QUE SE MANTIENEN (IMPORTANTES):</h2>";

$archivosImportantes = [
    'index.php',
    'comprar.php',
    'admin-dashboard.php',
    'dashboard-api.php',
    'properties.json',
    'contacto.html',
    'informacion-legal.html',
    'images/',
    'css/',
    'js/'
];

echo "<ul>";
foreach ($archivosImportantes as $archivo) {
    echo "<li>✅ $archivo</li>";
}
echo "</ul>";

echo "<h2>🚀 ¿PROCEDEMOS CON LA LIMPIEZA?</h2>";

if (isset($_GET['confirmar']) && $_GET['confirmar'] === 'si') {
    echo "<h3>🧹 ELIMINANDO ARCHIVOS...</h3>";
    
    $eliminados = 0;
    $errores = 0;
    
    // Eliminar archivos principales
    foreach ($archivosAEliminar as $archivo) {
        if (file_exists($archivo)) {
            if (unlink($archivo)) {
                echo "<p style='color: green;'>✅ Eliminado: $archivo</p>";
                $eliminados++;
            } else {
                echo "<p style='color: red;'>❌ Error al eliminar: $archivo</p>";
                $errores++;
            }
        } else {
            echo "<p style='color: orange;'>⚠️ No existe: $archivo</p>";
        }
    }
    
    // Eliminar archivos de backup
    foreach ($archivosBackup as $archivo) {
        if (unlink($archivo)) {
            echo "<p style='color: green;'>✅ Eliminado: $archivo</p>";
            $eliminados++;
        } else {
            echo "<p style='color: red;'>❌ Error al eliminar: $archivo</p>";
            $errores++;
        }
    }
    
    echo "<h3>📊 RESUMEN DE LIMPIEZA:</h3>";
    echo "<p><strong>Archivos eliminados:</strong> $eliminados</p>";
    echo "<p><strong>Errores:</strong> $errores</p>";
    
    if ($errores === 0) {
        echo "<p style='color: green; font-size: 1.2em; font-weight: bold;'>🎉 ¡LIMPIEZA COMPLETADA CON ÉXITO!</p>";
    } else {
        echo "<p style='color: orange; font-size: 1.2em; font-weight: bold;'>⚠️ Limpieza completada con algunos errores</p>";
    }
    
    echo "<h3>🔗 ENLACES PARA VERIFICAR:</h3>";
    echo "<ul>";
    echo "<li><a href='index.php' target='_blank'>Página principal</a></li>";
    echo "<li><a href='comprar.php' target='_blank'>Página de comprar</a></li>";
    echo "<li><a href='admin-dashboard.php' target='_blank'>Dashboard</a></li>";
    echo "</ul>";
    
} else {
    echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3>⚠️ ADVERTENCIA:</h3>";
    echo "<p>Esta acción eliminará permanentemente los archivos listados arriba.</p>";
    echo "<p><strong>Los archivos importantes se mantendrán intactos.</strong></p>";
    echo "<p>¿Estás seguro de que quieres proceder?</p>";
    echo "</div>";
    
    echo "<div style='margin: 20px 0;'>";
    echo "<a href='?confirmar=si' style='background: #dc3545; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; margin-right: 10px;'>🚀 SÍ, ELIMINAR ARCHIVOS</a>";
    echo "<a href='index.php' style='background: #6c757d; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px;'>❌ CANCELAR</a>";
    echo "</div>";
}

echo "<h2>📋 DESPUÉS DE LA LIMPIEZA:</h2>";
echo "<p>Tu servidor tendrá solo los archivos necesarios:</p>";
echo "<ul>";
echo "<li>✅ <strong>index.php</strong> - Página principal</li>";
echo "<li>✅ <strong>comprar.php</strong> - Página de propiedades</li>";
echo "<li>✅ <strong>admin-dashboard.php</strong> - Panel de administración</li>";
echo "<li>✅ <strong>dashboard-api.php</strong> - API del sistema</li>";
echo "<li>✅ <strong>properties.json</strong> - Datos de propiedades</li>";
echo "<li>✅ <strong>contacto.html</strong> - Página de contacto</li>";
echo "<li>✅ <strong>informacion-legal.html</strong> - Información legal</li>";
echo "<li>✅ <strong>carpetas de imágenes y estilos</strong></li>";
echo "</ul>";

echo "<p style='color: green; font-weight: bold;'>🎯 Tu web estará limpia y optimizada para funcionar perfectamente.</p>";
?>
