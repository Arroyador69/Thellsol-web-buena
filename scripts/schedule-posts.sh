#!/bin/bash

# Directorio del proyecto
PROJECT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )/.." && pwd )"

# Crear directorio de logs si no existe
mkdir -p "$PROJECT_DIR/logs"

# Crear el archivo crontab si no existe
CRON_FILE="/tmp/blog_cron"

# Programar la generación diaria a las 3 AM
echo "0 3 * * * cd $PROJECT_DIR && node scripts/generate-daily-post.js >> logs/blog-generation.log 2>&1" > $CRON_FILE

# Instalar el nuevo crontab
crontab $CRON_FILE

echo "Generación diaria de artículos programada para las 3 AM"
echo "Los logs se guardarán en $PROJECT_DIR/logs/blog-generation.log" 