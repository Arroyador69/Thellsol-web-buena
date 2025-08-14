#!/bin/bash

# Colores para los mensajes
RED='\033[0;31m'
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}🌐 Iniciando el servidor web...${NC}"

# Ir al directorio correcto
cd "$(dirname "$0")"

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

# Verificar si el puerto 3000 está en uso
if lsof -i :3000 > /dev/null; then
    echo -e "${BLUE}⚠️  El puerto 3000 está ocupado, usando el puerto 3001...${NC}"
    PORT=3001
else
    PORT=3000
fi

# Iniciar el servidor
echo -e "${GREEN}🚀 Iniciando el servidor web...${NC}"
echo -e "${GREEN}📱 La web estará disponible en: http://localhost:$PORT${NC}"
echo -e "${BLUE}⌨️  Presiona Ctrl+C para detener el servidor${NC}"

# Iniciar el servidor con el puerto seleccionado
PORT=$PORT npm run dev 