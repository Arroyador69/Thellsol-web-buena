# 🚀 Guía Completa de Migración a Vercel - ThellSol Real Estate

## 📋 Estado Actual
- ✅ Repositorio GitHub: `https://github.com/Arroyador69/Thellsol-web-buena.git`
- ✅ Dominio: `thellsol.com` (funcionando)
- ✅ Código: Listo para producción
- ⚠️ Pendiente: Despliegue en Vercel y configuración de base de datos

## 🎯 Objetivo
Migrar completamente desde Hostinger a Vercel + GitHub, manteniendo el dashboard funcional para que tus clientes puedan publicar propiedades.

---

## 📋 PASO 1: Configurar Base de Datos en la Nube

### Opción A: PlanetScale (Recomendado - Gratuito)
1. Ve a [planetscale.com](https://planetscale.com)
2. Crea una cuenta gratuita
3. Crea una nueva base de datos llamada `thellsol_db`
4. Obtén la URL de conexión MySQL

### Opción B: Railway
1. Ve a [railway.app](https://railway.app)
2. Crea una cuenta
3. Crea un nuevo proyecto MySQL
4. Obtén la URL de conexión

### Opción C: Supabase
1. Ve a [supabase.com](https://supabase.com)
2. Crea una cuenta gratuita
3. Crea un nuevo proyecto
4. Usa la base de datos PostgreSQL (más fácil de configurar)

---

## 📋 PASO 2: Desplegar en Vercel

### 2.1 Conectar con GitHub
1. Ve a [vercel.com](https://vercel.com)
2. Crea una cuenta o inicia sesión
3. Conecta tu cuenta de GitHub
4. Haz clic en "New Project"

### 2.2 Importar Repositorio
1. Selecciona el repositorio `Thellsol-web-buena`
2. Vercel detectará automáticamente que es un proyecto Next.js
3. Haz clic en "Deploy"

### 2.3 Configurar Variables de Entorno
En el dashboard de Vercel, ve a Settings > Environment Variables y añade:

```
DATABASE_URL=mysql://usuario:contraseña@host:puerto/thellsol_db
NEXTAUTH_URL=https://thellsol.com
NEXTAUTH_SECRET=tu-secreto-super-seguro-aqui
```

### 2.4 Configurar Dominio Personalizado
1. En Vercel, ve a Settings > Domains
2. Añade `thellsol.com`
3. Vercel te dará instrucciones para configurar los DNS

---

## 📋 PASO 3: Configurar DNS (Migrar desde Hostinger)

### 3.1 Obtener Configuración de Vercel
En el dashboard de Vercel, ve a Settings > Domains y copia:
- **Nameservers** de Vercel, o
- **Registros DNS** específicos

### 3.2 Actualizar DNS en Hostinger
1. Accede a tu panel de Hostinger
2. Ve a Dominios > thellsol.com > DNS
3. Cambia los nameservers a los de Vercel, o
4. Actualiza los registros A y CNAME según las instrucciones de Vercel

### 3.3 Verificar Configuración
- Los cambios pueden tardar hasta 48 horas
- Usa herramientas como [whatsmydns.net](https://whatsmydns.net) para verificar

---

## 📋 PASO 4: Configurar Base de Datos

### 4.1 Crear Tablas
Ejecuta este SQL en tu base de datos:

```sql
CREATE TABLE properties (
  id VARCHAR(255) PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  location VARCHAR(255) NOT NULL,
  type VARCHAR(50) NOT NULL,
  bedrooms INT,
  bathrooms INT,
  area DECIMAL(8,2),
  features JSON,
  images JSON,
  status VARCHAR(50) DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE users (
  id VARCHAR(255) PRIMARY KEY,
  name VARCHAR(255),
  email VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 4.2 Crear Usuario Administrador
Después del despliegue, ejecuta:
```bash
npm run create-admin
```

---

## 📋 PASO 5: Verificar Funcionalidad

### 5.1 Dashboard de Administración
- URL: `https://thellsol.com/admin`
- Funcionalidades:
  - ✅ Gestión de propiedades
  - ✅ Añadir nuevas propiedades
  - ✅ Editar propiedades existentes
  - ⚠️ Gestión de usuarios (en desarrollo)

### 5.2 APIs Verificadas
- ✅ `GET /api/properties` - Listar propiedades
- ✅ `POST /api/properties` - Crear propiedad
- ✅ `GET /api/properties/[id]` - Obtener propiedad específica
- ✅ `PUT /api/properties/[id]` - Actualizar propiedad

---

## 🔒 Consideraciones de Seguridad

### Variables de Entorno
- ✅ `NEXTAUTH_SECRET`: String aleatorio de 32+ caracteres
- ✅ `DATABASE_URL`: URL segura de la base de datos
- ✅ `NEXTAUTH_URL`: URL de producción

### Autenticación
- ✅ NextAuth configurado
- ✅ Página de login protegida
- ✅ Dashboard con autenticación

---

## 📞 Soporte y Mantenimiento

### Monitoreo
- Vercel Analytics (gratuito)
- Logs en tiempo real
- Alertas automáticas

### Actualizaciones
- Despliegues automáticos desde GitHub
- Rollback fácil en caso de problemas
- Preview deployments para testing

---

## 🎉 Resultado Final

Una vez completada la migración tendrás:
- ✅ Sitio web en Vercel (más rápido y seguro)
- ✅ Dashboard funcional para clientes
- ✅ Base de datos en la nube
- ✅ Dominio configurado
- ✅ Despliegues automáticos
- ✅ Sin dependencia de Hostinger

---

## 📞 Contacto
Para cualquier problema durante la migración:
- Email: info@thellsol.com
- Documentación: Este archivo
- Logs: Dashboard de Vercel
