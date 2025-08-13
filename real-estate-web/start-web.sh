#!/bin/bash

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}=== ThellSol Real Estate - Iniciando Web ===${NC}"

# Verificar si estamos en el directorio correcto
if [ ! -f "package.json" ]; then
    echo -e "${RED}Error: No se encontró package.json${NC}"
    echo -e "${YELLOW}Asegúrate de estar en el directorio real-estate-web${NC}"
    echo -e "${YELLOW}Ejecuta: cd real-estate-web${NC}"
    exit 1
fi

# Verificar si Node.js está instalado
if ! command -v node &> /dev/null; then
    echo -e "${RED}Error: Node.js no está instalado${NC}"
    echo -e "${YELLOW}Por favor, instala Node.js desde https://nodejs.org/${NC}"
    exit 1
fi

# Verificar versión de Node.js
NODE_VERSION=$(node -v | cut -d'v' -f2 | cut -d'.' -f1)
if [ "$NODE_VERSION" -lt 16 ]; then
    echo -e "${RED}Error: Node.js versión 16 o superior es requerida${NC}"
    echo -e "${YELLOW}Versión actual: $(node -v)${NC}"
    exit 1
fi

echo -e "${GREEN}✓ Node.js $(node -v) detectado${NC}"

# Verificar si npm está disponible
if ! command -v npm &> /dev/null; then
    echo -e "${RED}Error: npm no está disponible${NC}"
    exit 1
fi

echo -e "${GREEN}✓ npm $(npm -v) detectado${NC}"

# Instalar dependencias si no existen
if [ ! -d "node_modules" ]; then
    echo -e "${YELLOW}Instalando dependencias...${NC}"
    npm install
    if [ $? -ne 0 ]; then
        echo -e "${RED}Error al instalar dependencias${NC}"
        exit 1
    fi
    echo -e "${GREEN}✓ Dependencias instaladas${NC}"
else
    echo -e "${GREEN}✓ Dependencias ya instaladas${NC}"
fi

# Limpiar cache si es necesario
echo -e "${YELLOW}Limpiando cache...${NC}"
npm cache clean --force
echo -e "${GREEN}✓ Cache limpiado${NC}"

# Verificar puerto disponible
PORT=3000
while lsof -Pi :$PORT -sTCP:LISTEN -t >/dev/null ; do
    echo -e "${YELLOW}Puerto $PORT está en uso, probando puerto $((PORT + 1))${NC}"
    PORT=$((PORT + 1))
    if [ $PORT -gt 3010 ]; then
        echo -e "${RED}No se pudo encontrar un puerto disponible${NC}"
        exit 1
    fi
done

echo -e "${GREEN}✓ Puerto $PORT disponible${NC}"

# Iniciar el servidor de desarrollo
echo -e "${BLUE}Iniciando servidor de desarrollo en puerto $PORT...${NC}"
echo -e "${GREEN}La web estará disponible en: http://localhost:$PORT${NC}"
echo -e "${YELLOW}Presiona Ctrl+C para detener el servidor${NC}"
echo ""

# Iniciar el servidor
PORT=$PORT npm run dev 