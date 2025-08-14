#!/bin/bash

echo "🗄️ Configurando base de datos para ThellSol..."
echo ""

# Verificar que estamos en el directorio correcto
if [ ! -f "package.json" ]; then
    echo "❌ Error: No estás en el directorio del proyecto"
    echo "Ejecuta: cd real-estate-web"
    exit 1
fi

echo "📋 Opciones de base de datos:"
echo "1. PlanetScale (Recomendado - Gratuito)"
echo "2. Railway"
echo "3. Supabase"
echo "4. Tu propio servidor MySQL"
echo ""

read -p "Selecciona una opción (1-4): " db_option

case $db_option in
    1)
        echo "🌐 Configurando PlanetScale..."
        echo ""
        echo "📝 Instrucciones:"
        echo "1. Ve a https://planetscale.com y crea una cuenta"
        echo "2. Crea una nueva base de datos"
        echo "3. Ve a 'Connect' y copia la URL de conexión"
        echo "4. La URL debe verse así: mysql://usuario:contraseña@host:puerto/base_de_datos"
        echo ""
        read -p "Pega la URL de conexión de PlanetScale: " db_url
        
        if [ -n "$db_url" ]; then
            # Crear archivo .env.local
            echo "DATABASE_URL=\"$db_url\"" > .env.local
            echo "NEXTAUTH_URL=\"http://localhost:3000\"" >> .env.local
            echo "NEXTAUTH_SECRET=\"$(openssl rand -base64 32)\"" >> .env.local
            
            echo "✅ Variables de entorno configuradas"
        else
            echo "❌ No se proporcionó URL de base de datos"
            exit 1
        fi
        ;;
    2)
        echo "🚂 Configurando Railway..."
        echo "Ve a https://railway.app y sigue las instrucciones"
        ;;
    3)
        echo "🔧 Configurando Supabase..."
        echo "Ve a https://supabase.com y sigue las instrucciones"
        ;;
    4)
        echo "🖥️ Configurando servidor MySQL propio..."
        read -p "Host: " db_host
        read -p "Puerto: " db_port
        read -p "Usuario: " db_user
        read -p "Contraseña: " db_password
        read -p "Nombre de la base de datos: " db_name
        
        db_url="mysql://$db_user:$db_password@$db_host:$db_port/$db_name"
        
        # Crear archivo .env.local
        echo "DATABASE_URL=\"$db_url\"" > .env.local
        echo "NEXTAUTH_URL=\"http://localhost:3000\"" >> .env.local
        echo "NEXTAUTH_SECRET=\"$(openssl rand -base64 32)\"" >> .env.local
        
        echo "✅ Variables de entorno configuradas"
        ;;
    *)
        echo "❌ Opción no válida"
        exit 1
        ;;
esac

echo ""
echo "🔧 Instalando dependencias..."
npm install

echo ""
echo "🗄️ Generando cliente de Prisma..."
npx prisma generate

echo ""
echo "📊 Ejecutando migraciones..."
npx prisma db push

echo ""
echo "🎉 ¡Base de datos configurada correctamente!"
echo ""
echo "📋 Para continuar:"
echo "1. Ejecuta: npm run dev"
echo "2. Ve a http://localhost:3000/admin"
echo "3. Crea tu primera cuenta de administrador"
echo ""
echo "🔗 Para producción, configura las variables de entorno en Vercel" 