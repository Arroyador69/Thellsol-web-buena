#!/bin/bash

# Ruta absoluta al directorio del proyecto
PROJECT_DIR="/Users/albertogarciaarroyo/web andre tell/real-estate-web"

# Navegar al directorio del proyecto
cd "$PROJECT_DIR"

# Verificar que estamos en el directorio correcto
if [ ! -f "package.json" ]; then
  echo "Error: No se encuentra el archivo package.json en $PROJECT_DIR"
  exit 1
fi

# Iniciar el servidor simple
echo "Iniciando el servidor simple..."
echo "Accede a http://localhost:3000 en tu navegador"
node servir-html-directo.js 