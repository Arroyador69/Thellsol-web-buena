#!/bin/bash

# Cambiar al directorio del proyecto
cd "$(dirname "$0")/real-estate-web"

# Verificar si existe el directorio de certificados
if [ ! -d "certificates" ]; then
  echo "Creando certificados SSL..."
  mkdir certificates
  openssl req -x509 -newkey rsa:4096 -keyout certificates/localhost-key.pem -out certificates/localhost.pem -days 365 -nodes -subj "/CN=localhost"
fi

# Instalar dependencias si es necesario
if [ ! -d "node_modules" ]; then
  echo "Instalando dependencias..."
  npm install
fi

# Iniciar el servidor de desarrollo
echo "Iniciando servidor de desarrollo seguro..."
echo "Accede a: https://localhost:3000"
NODE_ENV=development npm run dev 