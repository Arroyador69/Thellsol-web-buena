# 🚀 CONEXIÓN DE HOSTINGER CON SUPABASE - ThellSol Real Estate

## ✅ **CONFIGURACIÓN COMPLETADA**

Tu web de Hostinger ya está configurada para conectarse con Supabase. Aquí tienes todo lo que necesitas saber:

## 📁 **ARCHIVOS CREADOS**

1. **`supabase-connection.php`** - Conexión con Supabase ✅
2. **`admin-dashboard.php`** - Dashboard para gestionar propiedades ✅
3. **`propiedades-dinamicas.php`** - Página que muestra propiedades de la base de datos ✅
4. **`test-connection.php`** - Archivo para probar la conexión ✅

## 🔧 **PASOS PARA IMPLEMENTAR**

### **PASO 1: Subir archivos a Hostinger**

Sube estos archivos a tu servidor de Hostinger:
- `supabase-connection.php`
- `admin-dashboard.php`
- `propiedades-dinamicas.php`
- `test-connection.php`

### **PASO 2: Probar la conexión**

1. Ve a: `https://tu-dominio.com/test-connection.php`
2. Deberías ver: "✅ Conexión exitosa con Supabase!"

### **PASO 3: Acceder al dashboard**

- **URL del dashboard**: `https://tu-dominio.com/admin-dashboard.php`
- **Funcionalidades**:
  - Añadir nuevas propiedades
  - Ver todas las propiedades
  - Eliminar propiedades
  - Editar información

### **PASO 4: Ver propiedades dinámicas**

- **URL**: `https://tu-dominio.com/propiedades-dinamicas.php`
- **Muestra**: Todas las propiedades de la base de datos

## 🎯 **CÓMO USAR EL DASHBOARD**

### **Añadir Nueva Propiedad**
1. Ve al dashboard admin
2. Completa el formulario:
   - **Título**: Nombre de la propiedad
   - **Descripción**: Detalles de la propiedad
   - **Precio**: Precio en euros
   - **Ubicación**: Ciudad/zona
   - **Tipo**: Apartamento, Villa, Casa, etc.
   - **Habitaciones**: Número de dormitorios
   - **Baños**: Número de baños
   - **Superficie**: Metros cuadrados
   - **Estado**: En Venta, En Alquiler, etc.
3. Haz clic en "Añadir Propiedad"

### **Gestionar Propiedades Existentes**
- **Ver**: Todas las propiedades aparecen en la lista
- **Eliminar**: Haz clic en "Eliminar" junto a cada propiedad

## 🔗 **INTEGRAR EN TU WEB**

### **Actualizar el menú de navegación**

En tu `index.html`, añade este enlace:
```html
<a href="propiedades-dinamicas.php" class="navbar-link">Propiedades</a>
```

### **Enlace al dashboard (solo para administradores)**
```html
<a href="admin-dashboard.php" class="navbar-link">Admin</a>
```

## 📊 **BASE DE DATOS SUPABASE**

### **Tabla Property**
- **id**: Identificador único
- **title**: Título de la propiedad
- **description**: Descripción
- **price**: Precio (número decimal)
- **location**: Ubicación
- **type**: Tipo de propiedad
- **bedrooms**: Número de habitaciones
- **bathrooms**: Número de baños
- **area**: Superficie en m²
- **features**: Características (JSON)
- **images**: URLs de imágenes (JSON)
- **status**: Estado (for-sale, for-rent, sold, rented)
- **createdAt**: Fecha de creación
- **updatedAt**: Fecha de actualización

## 🚨 **SOLUCIÓN DE PROBLEMAS**

### **Error de conexión**
1. Verifica que `supabase-connection.php` esté en el servidor
2. Comprueba que la anon key sea correcta
3. Ejecuta `test-connection.php` para diagnosticar

### **Error 404**
1. Verifica que los archivos estén en la carpeta correcta
2. Comprueba los permisos de archivo (644)

### **Error de permisos**
1. Asegúrate de que PHP tenga permisos de lectura
2. Verifica que cURL esté habilitado en tu hosting

## 📞 **SOPORTE**

### **Contacto**
- **Email**: info@thellsol.com
- **WhatsApp**: +34 676 335 313

### **Logs de error**
Si hay problemas, revisa los logs de error de PHP en tu panel de Hostinger.

## 🎉 **RESULTADO FINAL**

- ✅ **Tu web sigue en Hostinger** (sin cambios)
- ✅ **Base de datos en Supabase** (conectada)
- ✅ **Dashboard funcional** para gestionar propiedades
- ✅ **Propiedades dinámicas** que se actualizan automáticamente
- ✅ **Tu cliente puede gestionar propiedades** desde el dashboard

---

**¡Tu web ya está conectada con Supabase y lista para usar!** 🚀
