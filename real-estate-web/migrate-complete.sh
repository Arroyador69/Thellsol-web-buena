#!/bin/bash

echo "🚀 MIGRACIÓN COMPLETA A VERCEL - THELLSOL REAL ESTATE"
echo "=================================================="
echo ""

# Verificar que estamos en el directorio correcto
if [ ! -f "package.json" ]; then
    echo "❌ Error: No estás en el directorio del proyecto"
    echo "Ejecuta: cd real-estate-web"
    exit 1
fi

echo "📋 PASO 1: Configurar base de datos"
echo "-----------------------------------"
echo ""

# Ejecutar script de configuración de base de datos
if [ -f "setup-database.sh" ]; then
    echo "🔧 Ejecutando configuración de base de datos..."
    ./setup-database.sh
else
    echo "⚠️ Script de base de datos no encontrado"
    echo "Ejecuta manualmente: ./setup-database.sh"
fi

echo ""
echo "📋 PASO 2: Preparar repositorio para GitHub"
echo "-------------------------------------------"
echo ""

# Limpiar archivos innecesarios
echo "🧹 Limpiando archivos temporales..."
rm -rf .next out node_modules

# Verificar estado de Git
echo "📊 Estado actual de Git:"
git status

echo ""
echo "📝 ¿Quieres continuar con el commit? (y/n)"
read -r response
if [[ "$response" =~ ^([yY][eE][sS]|[yY])$ ]]; then
    # Añadir todos los archivos
    git add .
    
    # Hacer commit
    git commit -m "Migración completa a Vercel - Configuración de base de datos y autenticación"
    
    echo "✅ Commit realizado correctamente"
else
    echo "❌ Migración cancelada"
    exit 1
fi

echo ""
echo "🌐 PASO 3: Configurar repositorio remoto"
echo "---------------------------------------"
echo ""
echo "📝 Instrucciones:"
echo "1. Ve a https://github.com y crea un nuevo repositorio"
echo "2. Nombra el repositorio: thellsol-real-estate"
echo "3. NO inicialices con README, .gitignore o licencia"
echo "4. Copia la URL del repositorio"
echo ""
echo "📝 Pega la URL de tu repositorio de GitHub:"
read -r repo_url

if [ -n "$repo_url" ]; then
    # Añadir repositorio remoto
    git remote add origin "$repo_url"
    git branch -M main
    
    # Subir al repositorio
    echo "📤 Subiendo código a GitHub..."
    git push -u origin main
    
    echo "✅ Código subido a GitHub correctamente"
else
    echo "❌ No se proporcionó URL del repositorio"
    exit 1
fi

echo ""
echo "📋 PASO 4: Configurar Vercel"
echo "----------------------------"
echo ""
echo "🌐 Instrucciones para Vercel:"
echo "1. Ve a https://vercel.com y crea una cuenta"
echo "2. Conecta tu cuenta de GitHub"
echo "3. Haz clic en 'New Project'"
echo "4. Selecciona tu repositorio 'thellsol-real-estate'"
echo "5. Configura las variables de entorno:"
echo "   - DATABASE_URL: URL de tu base de datos MySQL"
echo "   - NEXTAUTH_URL: URL de tu sitio (ej: https://thellsol.vercel.app)"
echo "   - NEXTAUTH_SECRET: Un string aleatorio seguro"
echo "6. Haz clic en 'Deploy'"
echo ""

echo "📋 PASO 5: Crear usuario administrador"
echo "-------------------------------------"
echo ""
echo "🔧 Después del despliegue, ejecuta:"
echo "npm run create-admin"
echo ""

echo "🎉 ¡MIGRACIÓN COMPLETADA!"
echo "========================"
echo ""
echo "📋 Resumen de lo que se ha configurado:"
echo "✅ Base de datos MySQL configurada"
echo "✅ NextAuth para autenticación"
echo "✅ Página de login para administradores"
echo "✅ Script para crear usuario administrador"
echo "✅ Repositorio preparado para GitHub"
echo "✅ Configuración para Vercel"
echo ""
echo "🔗 Próximos pasos:"
echo "1. Configura Vercel siguiendo las instrucciones"
echo "2. Configura las variables de entorno en Vercel"
echo "3. Ejecuta: npm run create-admin (después del despliegue)"
echo "4. Accede a tu dashboard en: https://tu-dominio.vercel.app/admin"
echo ""
echo "📞 Para soporte: info@thellsol.com" 