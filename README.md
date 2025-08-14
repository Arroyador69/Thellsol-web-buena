# ThellSol Real Estate

Sitio web profesional para la inmobiliaria ThellSol Real Estate en la Costa del Sol.

## 🚀 Inicio Rápido

### Migración a Vercel (Recomendado)
```bash
# Ejecutar migración completa
./migrate-complete.sh
```

### Desarrollo Local
```bash
# Navegar al directorio del proyecto
cd real-estate-web

# Configurar base de datos
./setup-database.sh

# Instalar dependencias
npm install

# Generar cliente de Prisma
npm run db:generate

# Ejecutar migraciones
npm run db:push

# Crear usuario administrador
npm run create-admin

# Iniciar servidor de desarrollo
npm run dev
```

La web estará disponible en: http://localhost:3000

## 📋 Características

### 🏠 Páginas Principales
- **Inicio**: Página principal con hero section, propiedades destacadas y información de la empresa
- **Propiedades**: Lista de propiedades con filtros avanzados
- **Vender**: Información detallada del proceso de venta
- **Información Legal**: Contenido legal y videos informativos
- **Contacto**: Formulario de contacto e información de André

### 🔧 Dashboard de Administración
- **URL**: http://localhost:3000/admin
- **Funcionalidades**:
  - Gestión de propiedades
  - Añadir nuevas propiedades
  - Editar propiedades existentes
  - Gestión de usuarios (en desarrollo)
  - Configuración del sitio (en desarrollo)

### 🎨 Diseño y UX
- Diseño responsive y moderno
- Paleta de colores profesional (azul y blanco)
- Componentes reutilizables
- Optimización de imágenes
- Navegación intuitiva

## 🛠️ Tecnologías Utilizadas

- **Next.js 14**: Framework de React
- **TypeScript**: Tipado estático
- **Tailwind CSS**: Framework de CSS
- **React**: Biblioteca de UI
- **Next.js Image**: Optimización de imágenes

## 📁 Estructura del Proyecto

```
real-estate-web/
├── src/
│   ├── app/                    # Páginas de la aplicación
│   │   ├── admin/             # Dashboard de administración
│   │   ├── properties/        # Páginas de propiedades
│   │   ├── contact/           # Página de contacto
│   │   └── informacion-legal/ # Página legal
│   ├── components/            # Componentes reutilizables
│   └── types/                 # Definiciones de TypeScript
├── public/
│   └── images/               # Imágenes del sitio
├── start-web.sh              # Script de inicio
└── README.md                 # Este archivo
```

## 🎯 Categorías de Propiedades

### Tipos de Propiedad
- Apartamento
- Villa
- Casa
- Ático
- Terreno
- Local Comercial
- Oficina

### Ubicaciones
- Fuengirola
- Mijas
- Marbella
- Benalmádena
- Torremolinos
- Málaga Centro
- Nerja
- Estepona
- San Pedro de Alcántara
- Puerto Banús

### Características
- Parking
- Piscina
- Jardín
- Terraza
- Aire Acondicionado
- Calefacción
- Ascensor
- Amueblado

## 📝 Cómo Añadir Propiedades

1. **Acceder al Dashboard**:
   - Ve a http://localhost:3000/admin

2. **Añadir Nueva Propiedad**:
   - Haz clic en "Añadir Nueva Propiedad"
   - Completa todos los campos requeridos
   - Sube las imágenes de la propiedad
   - Guarda la propiedad

3. **Campos Requeridos**:
   - Título de la propiedad
   - Descripción
   - Precio
   - Ubicación
   - Tipo de propiedad
   - Estado (En Venta, En Alquiler, etc.)

## 🔍 Filtros de Búsqueda

Los usuarios pueden filtrar propiedades por:
- Ubicación
- Tipo de propiedad
- Rango de precios
- Número de habitaciones
- Número de baños
- Características especiales

## 🎨 Personalización

### Colores Principales
- Azul principal: `#1e40af` (blue-600)
- Azul oscuro: `#1e3a8a` (blue-800)
- Gris claro: `#f9fafb` (gray-50)

### Fuentes
- Inter (Google Fonts)

## 🚀 Despliegue

### Migración a Vercel (Recomendado)

#### Paso 1: Preparar el repositorio en GitHub
```bash
# Asegúrate de estar en el directorio del proyecto
cd real-estate-web

# Verificar el estado de Git
git status

# Añadir todos los archivos
git add .

# Hacer commit de los cambios
git commit -m "Preparar proyecto para Vercel"

# Crear repositorio en GitHub (desde la web de GitHub)
# Luego conectar tu repositorio local:
git remote add origin https://github.com/tu-usuario/thellsol-real-estate.git
git branch -M main
git push -u origin main
```

#### Paso 2: Configurar Vercel
1. Ve a [vercel.com](https://vercel.com) y crea una cuenta
2. Conecta tu cuenta de GitHub
3. Haz clic en "New Project"
4. Selecciona tu repositorio `thellsol-real-estate`
5. Configura las variables de entorno:
   - `DATABASE_URL`: URL de tu base de datos MySQL
   - `NEXTAUTH_URL`: URL de tu sitio (ej: https://thellsol.vercel.app)
   - `NEXTAUTH_SECRET`: Un string aleatorio seguro
6. Haz clic en "Deploy"

#### Paso 3: Configurar Base de Datos
Para el dashboard, necesitas una base de datos MySQL. Opciones:
- **PlanetScale** (recomendado, gratuito)
- **Railway**
- **Supabase**
- **Tu propio servidor MySQL**

#### Paso 4: Variables de Entorno en Vercel
En el dashboard de Vercel, ve a Settings > Environment Variables y añade:
```
DATABASE_URL=mysql://usuario:contraseña@host:puerto/base_de_datos
NEXTAUTH_URL=https://tu-dominio.vercel.app
NEXTAUTH_SECRET=tu-secreto-super-seguro
```

### Despliegue Manual (Alternativo)
```bash
# Construir la aplicación
npm run build

# Iniciar en modo producción
npm start
```

## 📞 Soporte

Para cualquier problema o pregunta:
- Email: info@thellsol.com
- Teléfono: +34 XXX XXX XXX

## 🔄 Actualizaciones

Para actualizar el proyecto:
```bash
# Actualizar dependencias
npm update

# Reinstalar dependencias si hay problemas
rm -rf node_modules package-lock.json
npm install
```

## 📱 Responsive Design

El sitio está optimizado para:
- Móviles (320px+)
- Tablets (768px+)
- Desktop (1024px+)
- Pantallas grandes (1280px+)

## 🔒 Seguridad

- Validación de formularios
- Sanitización de datos
- Protección contra XSS
- Headers de seguridad

---

**Desarrollado para ThellSol Real Estate** 🏠
