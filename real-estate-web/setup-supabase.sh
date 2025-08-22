#!/bin/bash

# 🚀 Script de Configuración Automática para Supabase - ThellSol Real Estate
# Este script configura automáticamente Supabase y despliega el proyecto

set -e  # Salir si hay algún error

echo "🏠 Configurando ThellSol Real Estate con Supabase..."
echo "=================================================="

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Función para imprimir mensajes
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Verificar que estamos en el directorio correcto
if [ ! -f "package.json" ]; then
    print_error "No se encontró package.json. Asegúrate de estar en el directorio del proyecto."
    exit 1
fi

print_status "Verificando dependencias..."

# Verificar si Node.js está instalado
if ! command -v node &> /dev/null; then
    print_error "Node.js no está instalado. Por favor, instala Node.js primero."
    exit 1
fi

# Verificar si npm está instalado
if ! command -v npm &> /dev/null; then
    print_error "npm no está instalado. Por favor, instala npm primero."
    exit 1
fi

print_success "Node.js y npm están instalados"

# Instalar dependencias
print_status "Instalando dependencias..."
npm install

# Verificar si existe .env.local
if [ ! -f ".env.local" ]; then
    print_warning "No se encontró .env.local. Creando archivo de ejemplo..."
    
    cat > .env.local << EOF
# Supabase Database URL
# Reemplaza con tu URL de Supabase
DATABASE_URL="postgresql://postgres:[tu-password]@db.[tu-project-ref].supabase.co:5432/postgres"

# NextAuth Configuration
NEXTAUTH_URL=http://localhost:3000
NEXTAUTH_SECRET=tu-secreto-super-seguro-aqui

# Para producción
# NEXTAUTH_URL=https://thellsol.com
EOF

    print_warning "Archivo .env.local creado. Por favor, configura tu DATABASE_URL de Supabase."
    print_status "Para obtener tu DATABASE_URL:"
    echo "1. Ve a https://supabase.com"
    echo "2. Crea un nuevo proyecto"
    echo "3. Ve a Settings > Database"
    echo "4. Copia la 'Database URL'"
    echo "5. Reemplaza la URL en .env.local"
    echo ""
    read -p "¿Has configurado la DATABASE_URL? (y/n): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        print_error "Por favor, configura la DATABASE_URL antes de continuar."
        exit 1
    fi
fi

# Generar cliente de Prisma
print_status "Generando cliente de Prisma..."
npm run db:generate

# Ejecutar migraciones
print_status "Ejecutando migraciones en Supabase..."
npm run db:push

# Crear usuario administrador
print_status "Creando usuario administrador..."
npm run create-admin

print_success "¡Configuración de Supabase completada!"

# Verificar que todo funciona
print_status "Verificando que la aplicación funciona..."
npm run build

print_success "¡Build completado exitosamente!"

echo ""
echo "🎉 ¡Configuración completada!"
echo "=============================="
echo ""
echo "📋 Próximos pasos:"
echo "1. Inicia el servidor: npm run dev"
echo "2. Ve a http://localhost:3000"
echo "3. Accede al admin en http://localhost:3000/admin"
echo ""
echo "🚀 Para desplegar en Vercel:"
echo "1. Sube el código a GitHub"
echo "2. Conecta el repositorio en Vercel"
echo "3. Configura las variables de entorno en Vercel"
echo ""
echo "📞 Si necesitas ayuda: info@thellsol.com"
echo ""

# Preguntar si quiere iniciar el servidor
read -p "¿Quieres iniciar el servidor de desarrollo ahora? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    print_status "Iniciando servidor de desarrollo..."
    npm run dev
fi
