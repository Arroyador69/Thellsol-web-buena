#!/bin/bash

echo "🚀 Iniciando migración a Vercel..."
echo ""

# Verificar que estamos en el directorio correcto
if [ ! -f "package.json" ]; then
    echo "❌ Error: No estás en el directorio del proyecto"
    echo "Ejecuta: cd real-estate-web"
    exit 1
fi

# Verificar que Git está inicializado
if [ ! -d ".git" ]; then
    echo "❌ Error: Git no está inicializado"
    echo "Ejecuta: git init"
    exit 1
fi

echo "📋 Paso 1: Preparando archivos para GitHub..."
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
    git commit -m "Preparar proyecto para migración a Vercel"
    
    echo "✅ Commit realizado correctamente"
else
    echo "❌ Migración cancelada"
    exit 1
fi

echo ""
echo "🌐 Paso 2: Configurar repositorio remoto"
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
echo "🎉 ¡Migración a GitHub completada!"
echo ""
echo "📋 Próximos pasos:"
echo "1. Ve a https://vercel.com y crea una cuenta"
echo "2. Conecta tu cuenta de GitHub"
echo "3. Haz clic en 'New Project'"
echo "4. Selecciona tu repositorio 'thellsol-real-estate'"
echo "5. Configura las variables de entorno:"
echo "   - DATABASE_URL"
echo "   - NEXTAUTH_URL"
echo "   - NEXTAUTH_SECRET"
echo "6. Haz clic en 'Deploy'"
echo ""
echo "🔗 Para más información, consulta el README.md" 