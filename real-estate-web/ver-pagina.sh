#!/bin/bash

# Navegar al directorio correcto
cd "/Users/albertogarciaarroyo/web andre tell/real-estate-web"

# Verificar que estamos en el directorio correcto
if [ ! -f "package.json" ]; then
  echo "Error: No se encuentra el archivo package.json. Asegúrate de estar en el directorio correcto."
  exit 1
fi

# Iniciar el servidor simple
echo "Iniciando el servidor simple..."
echo "Accede a http://localhost:3000 en tu navegador"
node servir-html.js 