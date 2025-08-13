#!/bin/bash

# Navegar al directorio correcto
cd "/Users/albertogarciaarroyo/web andre tell/real-estate-web"

# Verificar que estamos en el directorio correcto
if [ ! -f "package.json" ]; then
  echo "Error: No se encuentra el archivo package.json. Asegúrate de estar en el directorio correcto."
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
npm run dev 