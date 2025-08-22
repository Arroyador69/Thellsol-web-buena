#!/bin/bash

# 🚀 SOLUCIONAR WEB ONLINE - ThellSol Real Estate
# Comando para solucionar el problema de la web automáticamente

cd "$(dirname "$0")"

echo "🏠 SOLUCIONANDO WEB ONLINE - ThellSol Real Estate"
echo "=================================================="
echo ""

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

echo "🎯 PROBLEMA IDENTIFICADO:"
echo "   - Web no visible online"
echo "   - No hay base de datos en la nube"
echo "   - Proyecto usa SQLite local"
echo ""

echo "✅ SOLUCIÓN: Migración a Supabase + Vercel"
echo ""

print_status "PASO 1: Verificar configuración actual..."

# Verificar que estamos en el directorio correcto
if [ ! -f "package.json" ]; then
    print_error "No se encontró package.json. Asegúrate de estar en el directorio del proyecto."
    read -p "Presiona Enter para continuar..."
    exit 1
fi

print_success "Directorio del proyecto verificado"

# Verificar si .env.local existe
if [ ! -f ".env.local" ]; then
    print_warning "No se encontró .env.local"
    echo ""
    echo "📋 CONFIGURACIÓN NECESARIA:"
    echo "1. Ve a https://supabase.com"
    echo "2. Crea una cuenta gratuita"
    echo "3. Crea un nuevo proyecto llamado 'thellsol-real-estate'"
    echo "4. Ve a Settings > Database"
    echo "5. Copia la 'Database URL'"
    echo ""
    
    read -p "¿Has creado el proyecto en Supabase? (y/n): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        print_error "Por favor, crea el proyecto en Supabase primero."
        read -p "Presiona Enter para continuar..."
        exit 1
    fi
    
    # Crear .env.local
    print_status "Creando archivo .env.local..."
    cat > .env.local << EOF
# Supabase Database URL
# Reemplaza con tu URL de Supabase
DATABASE_URL="postgresql://postgres:[tu-password]@db.[tu-project-ref].supabase.co:5432/postgres"

# NextAuth Configuration
NEXTAUTH_URL=http://localhost:3000
NEXTAUTH_SECRET=thellsol-secreto-2024-super-seguro

# Para producción
# NEXTAUTH_URL=https://thellsol.com
EOF

    print_warning "Archivo .env.local creado."
    print_warning "IMPORTANTE: Edita el archivo .env.local y reemplaza la DATABASE_URL con tu URL de Supabase"
    echo ""
    read -p "¿Has configurado la DATABASE_URL en .env.local? (y/n): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        print_error "Por favor, configura la DATABASE_URL antes de continuar."
        read -p "Presiona Enter para continuar..."
        exit 1
    fi
else
    print_success "Archivo .env.local encontrado"
fi

print_status "PASO 2: Configurando Supabase..."

# Ejecutar script de configuración
if [ -f "setup-supabase.sh" ]; then
    ./setup-supabase.sh
else
    print_error "No se encontró setup-supabase.sh"
    read -p "Presiona Enter para continuar..."
    exit 1
fi

print_status "PASO 3: Desplegando en Vercel..."

# Preguntar si quiere desplegar en Vercel
read -p "¿Quieres desplegar en Vercel ahora? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    if [ -f "deploy-supabase-vercel.sh" ]; then
        ./deploy-supabase-vercel.sh
    else
        print_error "No se encontró deploy-supabase-vercel.sh"
    fi
else
    print_warning "Despliegue en Vercel omitido"
fi

echo ""
echo "🎉 ¡CONFIGURACIÓN COMPLETADA!"
echo "=============================="
echo ""
echo "📋 PRÓXIMOS PASOS:"
echo "1. Tu web estará en: https://tu-proyecto.vercel.app"
echo "2. Admin: https://tu-proyecto.vercel.app/admin"
echo "3. Login: admin@thellsol.com / admin123"
echo ""
echo "🔧 CONFIGURACIÓN ADICIONAL:"
echo "- Configura tu dominio personalizado en Vercel"
echo "- Añade propiedades desde el dashboard"
echo ""
echo "📞 Soporte: info@thellsol.com"
echo ""

read -p "Presiona Enter para cerrar..."
