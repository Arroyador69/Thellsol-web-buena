#!/bin/bash

# Ruta absoluta al directorio del proyecto
PROJECT_DIR="/Users/albertogarciaarroyo/web andre tell/real-estate-web"

# Navegar al directorio del proyecto
cd "$PROJECT_DIR"

# Verificar que estamos en el directorio correcto
if [ ! -f "package.json" ]; then
  echo "Error: No se encuentra el archivo package.json en $PROJECT_DIR"
  echo "Presiona Enter para salir..."
  read
  exit 1
fi

# Instalar dependencias si es necesario
if [ ! -d "node_modules" ]; then
  echo "Instalando dependencias..."
  npm install
fi

# Iniciar el servidor de desarrollo
echo "Iniciando el servidor de desarrollo..."
echo "Accede a http://localhost:3000 en tu navegador"
echo "Presiona Ctrl+C para detener el servidor"
npm run dev 