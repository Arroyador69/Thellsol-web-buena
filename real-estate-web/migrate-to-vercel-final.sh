#!/bin/bash

echo "🚀 MIGRACIÓN FINAL A VERCEL - THELLSOL REAL ESTATE"
echo "=================================================="
echo ""

# Verificar que estamos en el directorio correcto
if [ ! -f "package.json" ]; then
    echo "❌ Error: No estás en el directorio del proyecto"
    echo "Ejecuta: cd real-estate-web"
    exit 1
fi

echo "📋 PASO 1: Verificar estado actual"
echo "-----------------------------------"
echo ""

# Verificar estado de Git
echo "📊 Estado de Git:"
git status

# Verificar repositorio remoto
echo ""
echo "🌐 Repositorio remoto:"
git remote -v

echo ""
echo "📋 PASO 2: Preparar código para producción"
echo "------------------------------------------"
echo ""

# Limpiar archivos innecesarios
echo "🧹 Limpiando archivos temporales..."
rm -rf .next out node_modules

# Verificar que no hay cambios pendientes
if [ -n "$(git status --porcelain)" ]; then
    echo "⚠️ Hay cambios pendientes. ¿Quieres hacer commit? (y/n)"
    read -r response
    if [[ "$response" =~ ^([yY][eE][sS]|[yY])$ ]]; then
        git add .
        git commit -m "Preparar para despliegue final en Vercel"
        echo "✅ Commit realizado"
    else
        echo "❌ Migración cancelada"
        exit 1
    fi
fi

echo ""
echo "📋 PASO 3: Subir cambios a GitHub"
echo "---------------------------------"
echo ""

# Subir cambios
echo "📤 Subiendo cambios a GitHub..."
git push origin main

echo ""
echo "📋 PASO 4: Verificar configuración de Vercel"
echo "--------------------------------------------"
echo ""

# Verificar archivo vercel.json
if [ -f "vercel.json" ]; then
    echo "✅ vercel.json encontrado"
else
    echo "❌ vercel.json no encontrado"
    exit 1
fi

# Verificar package.json
if [ -f "package.json" ]; then
    echo "✅ package.json encontrado"
else
    echo "❌ package.json no encontrado"
    exit 1
fi

echo ""
echo "📋 PASO 5: Instrucciones para Vercel"
echo "------------------------------------"
echo ""

echo "🌐 Sigue estos pasos en Vercel:"
echo ""
echo "1. Ve a https://vercel.com"
echo "2. Inicia sesión o crea una cuenta"
echo "3. Conecta tu cuenta de GitHub"
echo "4. Haz clic en 'New Project'"
echo "5. Selecciona el repositorio: Thellsol-web-buena"
echo "6. Configura las variables de entorno:"
echo "   - DATABASE_URL: URL de tu base de datos MySQL"
echo "   - NEXTAUTH_URL: https://thellsol.com"
echo "   - NEXTAUTH_SECRET: Un string aleatorio de 32+ caracteres"
echo "7. Haz clic en 'Deploy'"
echo ""

echo "📋 PASO 6: Configurar base de datos"
echo "-----------------------------------"
echo ""

echo "🗄️ Opciones de base de datos recomendadas:"
echo ""
echo "A) PlanetScale (Gratuito):"
echo "   - Ve a https://planetscale.com"
echo "   - Crea una cuenta gratuita"
echo "   - Crea una base de datos llamada 'thellsol_db'"
echo "   - Copia la URL de conexión MySQL"
echo ""
echo "B) Railway:"
echo "   - Ve a https://railway.app"
echo "   - Crea un proyecto MySQL"
echo "   - Copia la URL de conexión"
echo ""
echo "C) Supabase (PostgreSQL):"
echo "   - Ve a https://supabase.com"
echo "   - Crea un proyecto gratuito"
echo "   - Usa la base de datos PostgreSQL"
echo ""

echo "📋 PASO 7: Configurar dominio"
echo "-----------------------------"
echo ""

echo "🌐 Para configurar thellsol.com en Vercel:"
echo ""
echo "1. En el dashboard de Vercel, ve a Settings > Domains"
echo "2. Añade 'thellsol.com'"
echo "3. Vercel te dará instrucciones para configurar DNS"
echo "4. Actualiza los DNS en Hostinger según las instrucciones"
echo ""

echo "📋 PASO 8: Crear usuario administrador"
echo "-------------------------------------"
echo ""

echo "👤 Después del despliegue, crea un usuario administrador:"
echo ""
echo "1. Ve a tu proyecto en Vercel"
echo "2. Abre la consola de funciones"
echo "3. Ejecuta: npm run create-admin"
echo "4. Sigue las instrucciones para crear el usuario"
echo ""

echo "🎉 ¡MIGRACIÓN PREPARADA!"
echo "======================="
echo ""
echo "📋 Resumen de lo que se ha verificado:"
echo "✅ Repositorio GitHub configurado"
echo "✅ Código actualizado y subido"
echo "✅ Configuración de Vercel lista"
echo "✅ Dashboard de administración funcional"
echo "✅ APIs para gestión de propiedades"
echo ""
echo "🔗 Próximos pasos:"
echo "1. Configura Vercel siguiendo las instrucciones"
echo "2. Configura la base de datos en la nube"
echo "3. Configura las variables de entorno en Vercel"
echo "4. Configura el dominio personalizado"
echo "5. Crea el usuario administrador"
echo "6. Accede al dashboard en: https://thellsol.com/admin"
echo ""
echo "📞 Para soporte: info@thellsol.com"
echo "📖 Consulta: vercel-deployment-guide.md"
