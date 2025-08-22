#!/bin/bash

# 🚀 Script de Despliegue Rápido en Vercel con Supabase - ThellSol Real Estate

set -e

echo "🚀 Desplegando ThellSol Real Estate en Vercel con Supabase..."
echo "============================================================="

# Colores
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

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

# Verificar que .env.local existe
if [ ! -f ".env.local" ]; then
    print_error "No se encontró .env.local. Ejecuta primero ./setup-supabase.sh"
    exit 1
fi

print_status "Verificando configuración..."

# Verificar que DATABASE_URL está configurada
if ! grep -q "DATABASE_URL" .env.local; then
    print_error "DATABASE_URL no está configurada en .env.local"
    exit 1
fi

print_success "Configuración verificada"

# Instalar dependencias si no están instaladas
if [ ! -d "node_modules" ]; then
    print_status "Instalando dependencias..."
    npm install
fi

# Generar cliente de Prisma
print_status "Generando cliente de Prisma..."
npm run db:generate

# Ejecutar migraciones
print_status "Ejecutando migraciones en Supabase..."
npm run db:push

# Build del proyecto
print_status "Construyendo el proyecto..."
npm run build

print_success "Build completado"

# Verificar si Vercel CLI está instalado
if ! command -v vercel &> /dev/null; then
    print_warning "Vercel CLI no está instalado. Instalando..."
    npm install -g vercel
fi

print_status "Iniciando despliegue en Vercel..."

# Desplegar en Vercel
vercel --prod

print_success "¡Despliegue completado!"

echo ""
echo "🎉 ¡Tu web está online!"
echo "======================="
echo ""
echo "📋 Próximos pasos:"
echo "1. Configura tu dominio personalizado en Vercel"
echo "2. Accede al admin en tu-dominio.vercel.app/admin"
echo "3. Añade propiedades desde el dashboard"
echo ""
echo "🔧 Configuración adicional:"
echo "- Ve a Vercel Dashboard > Settings > Environment Variables"
echo "- Verifica que DATABASE_URL, NEXTAUTH_URL y NEXTAUTH_SECRET estén configuradas"
echo ""
echo "📞 Soporte: info@thellsol.com"
echo ""
