#!/bin/bash

# Cambiar al directorio del proyecto
cd "$(dirname "$0")"

# Iniciar el servidor Node.js
echo "Iniciando servidor local..."
echo "Accede a: http://localhost:8080"
node servir-html-local.js 