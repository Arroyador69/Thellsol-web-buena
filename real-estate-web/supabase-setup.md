# 🚀 Configuración de Supabase para ThellSol Real Estate

## 📋 Pasos para Configurar Supabase

### 1. Crear Cuenta en Supabase
1. Ve a [supabase.com](https://supabase.com)
2. Crea una cuenta gratuita
3. Haz clic en "New Project"

### 2. Configurar el Proyecto
- **Nombre del proyecto**: `thellsol-real-estate`
- **Contraseña de la base de datos**: `thellsol2024!` (o la que prefieras)
- **Región**: `West Europe` (más cerca de España)

### 3. Obtener las Credenciales
Una vez creado el proyecto, ve a Settings > Database y copia:
- **Database URL**: `postgresql://postgres:[password]@db.[project-ref].supabase.co:5432/postgres`
- **Anon Key**: Para el frontend
- **Service Role Key**: Para el backend

### 4. Configurar Variables de Entorno
Crea un archivo `.env.local` en la raíz del proyecto:

```env
# Supabase Database URL
DATABASE_URL="postgresql://postgres:[tu-password]@db.[tu-project-ref].supabase.co:5432/postgres"

# NextAuth Configuration
NEXTAUTH_URL=http://localhost:3000
NEXTAUTH_SECRET=tu-secreto-super-seguro-aqui

# Para producción
# NEXTAUTH_URL=https://thellsol.com
```

### 5. Ejecutar Migraciones
```bash
# Instalar dependencias
npm install

# Generar cliente de Prisma
npm run db:generate

# Ejecutar migraciones en Supabase
npm run db:push

# Crear usuario administrador
npm run create-admin
```

### 6. Configurar RLS (Row Level Security)
En Supabase Dashboard > Authentication > Policies:

```sql
-- Habilitar RLS en las tablas
ALTER TABLE "User" ENABLE ROW LEVEL SECURITY;
ALTER TABLE "Property" ENABLE ROW LEVEL SECURITY;

-- Política para usuarios (solo pueden ver sus propios datos)
CREATE POLICY "Users can view own data" ON "User"
FOR SELECT USING (auth.uid()::text = id);

-- Política para propiedades (público puede ver, admin puede editar)
CREATE POLICY "Properties are viewable by everyone" ON "Property"
FOR SELECT USING (true);

CREATE POLICY "Properties are insertable by authenticated users" ON "Property"
FOR INSERT WITH CHECK (auth.role() = 'authenticated');

CREATE POLICY "Properties are updatable by authenticated users" ON "Property"
FOR UPDATE USING (auth.role() = 'authenticated');
```

## 🔧 Configuración para Vercel

### Variables de Entorno en Vercel
En el dashboard de Vercel, ve a Settings > Environment Variables:

```env
DATABASE_URL=postgresql://postgres:[password]@db.[project-ref].supabase.co:5432/postgres
NEXTAUTH_URL=https://thellsol.com
NEXTAUTH_SECRET=tu-secreto-super-seguro-aqui
```

## 📊 Ventajas de Supabase

### ✅ **Gratuito hasta 500MB**
- Base de datos PostgreSQL
- Autenticación integrada
- API REST automática
- Dashboard web
- Backups automáticos

### ✅ **Funcionalidades Incluidas**
- Autenticación con email/password
- Autenticación social (Google, GitHub)
- Row Level Security (RLS)
- API REST automática
- Real-time subscriptions
- Storage para archivos

### ✅ **Escalabilidad**
- Fácil upgrade a planes pagados
- Sin límites de consultas en plan gratuito
- CDN global incluido

## 🚀 Despliegue Rápido

### Script Automático
```bash
# Ejecutar configuración completa
./setup-supabase.sh
```

### Verificación
1. Ve a tu proyecto en Supabase
2. Tabla > Properties > Verifica que las tablas se crearon
3. Authentication > Users > Verifica que el admin se creó
4. API > Verifica que los endpoints funcionan

## 📞 Soporte

Si tienes problemas:
1. Revisa los logs en Supabase Dashboard
2. Verifica las variables de entorno
3. Contacta: info@thellsol.com

---

**¡Con Supabase tu web estará online en minutos!** ⚡
