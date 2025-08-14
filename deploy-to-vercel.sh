#!/bin/bash

echo "🚀 Preparando despliegue a Vercel..."

# Verificar que estamos en el directorio correcto
if [ ! -f "package.json" ]; then
    echo "❌ Error: No estás en el directorio del proyecto"
    exit 1
fi

# Instalar dependencias
echo "📦 Instalando dependencias..."
npm install

# Generar cliente de Prisma
echo "🔧 Generando cliente de Prisma..."
npx prisma generate

# Construir el proyecto
echo "🏗️ Construyendo el proyecto..."
npm run build

# Verificar que la construcción fue exitosa
if [ $? -eq 0 ]; then
    echo "✅ Construcción exitosa"
    echo ""
    echo "📋 Próximos pasos:"
    echo "1. Sube el código a GitHub:"
    echo "   git add ."
    echo "   git commit -m 'Dashboard completo'"
    echo "   git push"
    echo ""
    echo "2. Ve a vercel.com y conecta tu repositorio"
    echo ""
    echo "3. Configura las variables de entorno en Vercel:"
    echo "   - DATABASE_URL: URL de tu base de datos MySQL"
    echo "   - NEXTAUTH_URL: URL de tu sitio Vercel"
    echo "   - NEXTAUTH_SECRET: String aleatorio seguro"
    echo ""
    echo "4. Ejecuta el script SQL en tu base de datos"
    echo ""
    echo "🎉 ¡Tu dashboard estará listo!"
else
    echo "❌ Error en la construcción"
    exit 1
fi
