#!/bin/bash

# Colores para los mensajes
RED='\033[0;31m'
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

# Función para mostrar mensajes
print_message() {
    echo -e "${BLUE}$1${NC}"
}

print_error() {
    echo -e "${RED}$1${NC}"
}

print_success() {
    echo -e "${GREEN}$1${NC}"
}

# Asegurar que estamos en el directorio correcto
SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
cd "$SCRIPT_DIR"

print_message "🔍 Verificando el entorno..."

# Verificar si node está instalado
if ! command -v node &> /dev/null; then
    print_error "❌ Node.js no está instalado. Por favor, instálalo desde https://nodejs.org"
    exit 1
fi

# Verificar si el package.json existe
if [ ! -f "package.json" ]; then
    print_error "❌ No se encuentra package.json. Asegúrate de estar en el directorio correcto."
    exit 1
fi

print_message "🧹 Limpiando caché y node_modules..."
rm -rf node_modules
rm -rf .next
npm cache clean --force

print_message "📦 Instalando dependencias..."
npm install

if [ $? -eq 0 ]; then
    print_success "✅ Dependencias instaladas correctamente"
else
    print_error "❌ Error instalando dependencias"
    exit 1
fi

print_message "🚀 Iniciando el servidor..."
print_message "📱 La web estará disponible en: http://localhost:3000"
print_message "⌨️  Presiona Ctrl+C para detener el servidor"

# Intentar iniciar el servidor
npm run dev

# Si el servidor falla, intentar con un puerto diferente
if [ $? -ne 0 ]; then
    print_message "⚠️  El puerto 3000 podría estar ocupado. Intentando con el puerto 3001..."
    npm run dev -- -p 3001
fi 