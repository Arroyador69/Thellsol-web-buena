#!/bin/bash

# Colores para los mensajes
RED='\033[0;31m'
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}🌐 Iniciando el servidor web...${NC}"

# Ir al directorio correcto
cd "$(dirname "$0")/real-estate-web"

# Verificar si estamos en el directorio correcto
if [ ! -f "package.json" ]; then
    echo -e "${RED}❌ Error: No se encuentra el archivo package.json${NC}"
    echo -e "${RED}Por favor, asegúrate de que el script está en la carpeta correcta${NC}"
    exit 1
fi

# Limpiar instalaciones anteriores
echo -e "${BLUE}🧹 Limpiando instalación anterior...${NC}"
rm -rf node_modules
rm -rf .next
npm cache clean --force

# Instalar dependencias
echo -e "${BLUE}📦 Instalando dependencias...${NC}"
npm install

# Iniciar el servidor
echo -e "${GREEN}🚀 Iniciando el servidor web...${NC}"
echo -e "${GREEN}📱 La web estará disponible en: http://localhost:3000${NC}"
echo -e "${BLUE}⌨️  Presiona Ctrl+C para detener el servidor${NC}"

npm run dev 