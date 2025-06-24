# Dashboard ThellSol Real Estate

## 🏠 Sistema de Gestión de Propiedades

Este dashboard permite gestionar todas las propiedades de ThellSol Real Estate de manera fácil y eficiente.

## 📋 Características

- ✅ **Autenticación segura** con usuario y contraseña
- 🏠 **Gestión completa de propiedades** (CRUD)
- 📸 **Subida de imágenes** con drag & drop
- 🎨 **Interfaz moderna y responsive**
- 📊 **Estadísticas en tiempo real**
- 🔍 **Búsqueda y filtros**
- 🌍 **Soporte multiidioma** (preparado)

## 🚀 Instalación

### 1. Configuración de Base de Datos

1. Crea una base de datos MySQL llamada `thellsol_db`
2. Importa el archivo `../database.sql` en tu base de datos
3. Configura las credenciales en `../config.php`

### 2. Configuración del Servidor

Asegúrate de que tu servidor tenga:
- PHP 7.4 o superior
- MySQL/MariaDB
- Extensiones PHP: PDO, PDO_MySQL

### 3. Permisos de Archivos

```bash
chmod 755 uploads/
chmod 644 config.php
```

## 🔐 Acceso al Dashboard

**URL:** `https://tudominio.com/dashboard/`

**Credenciales por defecto:**
- **Usuario:** `admin`
- **Contraseña:** `thellsol2024!`

⚠️ **IMPORTANTE:** Cambia la contraseña en `config.php` antes de usar en producción.

## 📁 Estructura de Archivos

```
dashboard/
├── index.php          # Dashboard principal
├── login.php          # Página de login
├── logout.php         # Cerrar sesión
├── images.php         # Gestión de imágenes
├── auth.php           # Verificación de autenticación
└── README.md          # Este archivo

api/
├── properties.php     # API de propiedades
├── images.php         # API de imágenes
└── upload-image.php   # Subida de imágenes

uploads/               # Directorio de imágenes
config.php             # Configuración general
database.sql           # Script de base de datos
```

## 🎯 Funcionalidades

### Gestión de Propiedades
- ✅ Crear nuevas propiedades
- ✅ Editar propiedades existentes
- ✅ Eliminar propiedades
- ✅ Subir imágenes
- ✅ Gestionar características (piscina, jardín, etc.)

### Gestión de Imágenes
- ✅ Subida múltiple de imágenes
- ✅ Drag & drop
- ✅ Vista previa
- ✅ Eliminación de imágenes
- ✅ Copiar URLs

### Estadísticas
- 📊 Total de propiedades
- 📊 Propiedades activas
- 📊 Precio promedio

## 🔧 Configuración Avanzada

### Personalizar Credenciales

Edita `../config.php`:

```php
define('ADMIN_USERNAME', 'tu_usuario');
define('ADMIN_PASSWORD', 'tu_contraseña_segura');
```

### Configurar Base de Datos

```php
$host = 'localhost';
$dbname = 'thellsol_db';
$username = 'tu_usuario_db';
$password = 'tu_password_db';
```

### Límites de Archivos

```php
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
```

## 🛡️ Seguridad

- ✅ Autenticación requerida
- ✅ Validación de archivos
- ✅ Sanitización de datos
- ✅ Protección contra XSS
- ✅ Límites de tamaño de archivo

## 📱 Responsive Design

El dashboard es completamente responsive y funciona en:
- 💻 Desktop
- 📱 Tablet
- 📱 Móvil

## 🔄 API Endpoints

### Propiedades
- `GET /api/properties.php` - Obtener todas las propiedades
- `GET /api/properties.php?id=X` - Obtener propiedad específica
- `POST /api/properties.php` - Crear nueva propiedad
- `PUT /api/properties.php` - Actualizar propiedad
- `DELETE /api/properties.php?id=X` - Eliminar propiedad

### Imágenes
- `GET /api/images.php` - Obtener lista de imágenes
- `DELETE /api/images.php?id=X` - Eliminar imagen
- `POST /api/upload-image.php` - Subir imagen

## 🐛 Solución de Problemas

### Error de Conexión a BD
- Verifica las credenciales en `config.php`
- Asegúrate de que MySQL esté ejecutándose
- Verifica que la base de datos existe

### Error al Subir Imágenes
- Verifica permisos del directorio `uploads/`
- Comprueba el tamaño máximo de archivo
- Verifica que el tipo de archivo esté permitido

### Error de Sesión
- Verifica que las sesiones estén habilitadas en PHP
- Comprueba la configuración de cookies

## 📞 Soporte

Para soporte técnico, contacta con el equipo de desarrollo.

## 📄 Licencia

Este software es propiedad de ThellSol Real Estate.

---

**Versión:** 1.0  
**Última actualización:** Diciembre 2024 