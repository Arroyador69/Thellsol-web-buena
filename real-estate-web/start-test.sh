#!/bin/bash

# Navegar al directorio correcto
cd "$(dirname "$0")"

# Verificar que estamos en el directorio correcto
if [ ! -f "package.json" ]; then
  echo "Error: No se encuentra el archivo package.json. Asegúrate de estar en el directorio correcto."
  exit 1
fi

# Iniciar el servidor de prueba
echo "Iniciando el servidor de prueba..."
echo "Accede a http://localhost:3000 en tu navegador"
node serve-test.js 