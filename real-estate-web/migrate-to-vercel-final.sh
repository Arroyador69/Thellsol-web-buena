#!/bin/bash

echo "🚀 MIGRACIÓN COMPLETA A VERCEL - THELLSOL REAL ESTATE"
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

print_status "Verificando estado del proyecto..."

# Verificar Git
if ! command -v git &> /dev/null; then
    print_error "Git no está instalado. Por favor instala Git primero."
    exit 1
fi

# Verificar Node.js
if ! command -v node &> /dev/null; then
    print_error "Node.js no está instalado. Por favor instala Node.js primero."
    exit 1
fi

# Verificar npm
if ! command -v npm &> /dev/null; then
    print_error "npm no está instalado. Por favor instala npm primero."
    exit 1
fi

print_success "Dependencias básicas verificadas"

# Paso 1: Instalar dependencias
print_status "Instalando dependencias..."
npm install
if [ $? -eq 0 ]; then
    print_success "Dependencias instaladas correctamente"
else
    print_error "Error al instalar dependencias"
    exit 1
fi

# Paso 2: Generar cliente de Prisma
print_status "Generando cliente de Prisma..."
npm run db:generate
if [ $? -eq 0 ]; then
    print_success "Cliente de Prisma generado"
else
    print_warning "Error al generar cliente de Prisma (puede ser normal si no hay base de datos configurada)"
fi

# Paso 3: Verificar configuración de Vercel
print_status "Verificando configuración de Vercel..."
if [ -f "vercel.json" ]; then
    print_success "vercel.json encontrado"
else
    print_warning "vercel.json no encontrado - se creará automáticamente en Vercel"
fi

# Paso 4: Verificar variables de entorno
print_status "Verificando archivo de variables de entorno..."
if [ -f ".env.local" ]; then
    print_success "Archivo .env.local encontrado"
    print_warning "IMPORTANTE: Asegúrate de configurar estas variables en Vercel:"
    echo "  - DATABASE_URL"
    echo "  - NEXTAUTH_URL"
    echo "  - NEXTAUTH_SECRET"
else
    print_warning "Archivo .env.local no encontrado"
    print_status "Creando archivo .env.example..."
    cat > .env.example << EOF
# Base de datos
DATABASE_URL="mysql://usuario:contraseña@host:puerto/base_de_datos"

# NextAuth
NEXTAUTH_URL="https://tu-dominio.vercel.app"
NEXTAUTH_SECRET="tu-secreto-super-seguro"

# Opcional: Google Translate API
GOOGLE_TRANSLATE_API_KEY="tu-api-key"
EOF
    print_success "Archivo .env.example creado"
fi

# Paso 5: Verificar estructura del proyecto
print_status "Verificando estructura del proyecto..."
required_files=("src/app/layout.tsx" "src/app/page.tsx" "src/app/admin/page.tsx" "package.json" "next.config.js")
for file in "${required_files[@]}"; do
    if [ -f "$file" ]; then
        print_success "✓ $file"
    else
        print_error "✗ $file (FALTANTE)"
    fi
done

# Paso 6: Build de prueba
print_status "Realizando build de prueba..."
npm run build
if [ $? -eq 0 ]; then
    print_success "Build exitoso - El proyecto está listo para Vercel"
else
    print_error "Error en el build - Revisa los errores antes de continuar"
    exit 1
fi

# Paso 7: Verificar Git
print_status "Verificando estado de Git..."
git status --porcelain
if [ $? -eq 0 ]; then
    print_success "Repositorio Git verificado"
else
    print_warning "Problemas con Git - Verifica el estado del repositorio"
fi

echo ""
echo "🎉 MIGRACIÓN PREPARADA EXITOSAMENTE"
echo "=================================="
echo ""
echo "📋 PRÓXIMOS PASOS:"
echo ""
echo "1. 🌐 CONFIGURAR VERCEL:"
echo "   - Ve a https://vercel.com"
echo "   - Conecta tu cuenta de GitHub"
echo "   - Importa el repositorio: Thellsol-web-buena"
echo "   - Configura las variables de entorno"
echo ""
echo "2. 🗄️ CONFIGURAR BASE DE DATOS:"
echo "   - Opción A: PlanetScale (recomendado, gratuito)"
echo "   - Opción B: Railway"
echo "   - Opción C: Supabase"
echo "   - Opción D: Tu propio servidor MySQL"
echo ""
echo "3. 🔧 VARIABLES DE ENTORNO EN VERCEL:"
echo "   DATABASE_URL=mysql://usuario:contraseña@host:puerto/base_de_datos"
echo "   NEXTAUTH_URL=https://tu-dominio.vercel.app"
echo "   NEXTAUTH_SECRET=tu-secreto-super-seguro"
echo ""
echo "4. 👤 CREAR USUARIO ADMIN:"
echo "   - Una vez desplegado, ejecuta: npm run create-admin"
echo "   - O usa el script: ./scripts/create-admin.js"
echo ""
echo "5. 🧪 PROBAR DASHBOARD:"
echo "   - URL: https://tu-dominio.vercel.app/admin"
echo "   - Añadir propiedades de prueba"
echo "   - Verificar que aparezcan en la web"
echo ""
echo "📞 SOPORTE:"
echo "   - Email: info@thellsol.com"
echo "   - Documentación: README.md"
echo ""
print_success "¡Proyecto listo para desplegar en Vercel!"
