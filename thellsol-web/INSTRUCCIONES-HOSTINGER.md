# INSTRUCCIONES PARA SUBIR A HOSTINGER

## 🎯 OBJETIVO
Implementar la funcionalidad para que al hacer clic en "Ver Detalles" de una propiedad se abra una nueva página con todos los detalles de esa propiedad específica.

## 📁 ARCHIVOS QUE DEBES SUBIR A HOSTINGER

### 1. ARCHIVO PRINCIPAL (OBLIGATORIO)
- **`propiedad-detalles.php`** - Este es el archivo más importante que debes subir

### 2. ARCHIVOS QUE YA DEBERÍAN ESTAR EN HOSTINGER
- `properties.json` - Con la información de las propiedades
- `index.php` - Página principal
- `comprar.php` - Página de compra
- `images/` - Carpeta con las imágenes del carrusel

## 🚀 PASOS PARA IMPLEMENTAR

### Paso 1: Subir el archivo principal
1. Ve a tu panel de Hostinger
2. Navega a `public_html`
3. Sube el archivo `propiedad-detalles.php` que acabamos de crear

### Paso 2: Verificar que existan estos archivos
Asegúrate de que en tu `public_html` tengas:
- ✅ `properties.json` (con las propiedades)
- ✅ `index.php` (página principal)
- ✅ `comprar.php` (página de compra)
- ✅ `images/` (carpeta con imágenes)

### Paso 3: Probar la funcionalidad
1. Ve a tu página principal (`index.php`)
2. Haz clic en "Ver Detalles" de cualquier propiedad
3. Debería abrirse una nueva página con todos los detalles

## 🔧 CÓMO FUNCIONA

### Enlaces existentes:
- **En `index.php`**: Línea ~580: `<a href="propiedad-detalles.php?id=<?php echo urlencode($property['id']); ?>" class="card-btn">Ver Detalles</a>`
- **En `comprar.php`**: Línea ~580: `<a href="propiedad-detalles.php?id=<?php echo urlencode($property['id'] ?? uniqid()); ?>" class="property-btn">Ver Detalles</a>`

### Flujo de funcionamiento:
1. Usuario hace clic en "Ver Detalles"
2. Se redirige a `propiedad-detalles.php?id=PROPERTY_ID`
3. La página carga los datos de `properties.json`
4. Muestra la propiedad específica con todas sus imágenes y detalles
5. Si no hay imágenes reales, usa las del carrusel como fallback

## 🖼️ MANEJO DE IMÁGENES

### Imágenes por defecto:
Si una propiedad no tiene imágenes o tiene URLs de ejemplo (`example.com`), la página automáticamente usará:
- `images/carrusel2.jpeg`
- `images/carrusel3.jpeg`
- `images/carrusel4.jpeg`
- `images/carrusel5.jpeg`
- `images/carrusel6.jpeg`

### Galería de imágenes:
- La primera imagen se muestra como imagen principal
- Si hay más imágenes, aparecen como miniaturas debajo
- Al hacer clic en una miniatura, cambia la imagen principal

## ✅ VERIFICACIÓN

### Después de subir, verifica que:
1. ✅ Los enlaces "Ver Detalles" funcionen en `index.php`
2. ✅ Los enlaces "Ver Detalles" funcionen en `comprar.php`
3. ✅ Se abra la página de detalles con la información correcta
4. ✅ Las imágenes se muestren correctamente
5. ✅ Los botones de contacto (WhatsApp y Email) funcionen

## 🆘 SOLUCIÓN DE PROBLEMAS

### Si no funciona:
1. **Verifica que `propiedad-detalles.php` esté en `public_html`**
2. **Asegúrate de que `properties.json` tenga el formato correcto**
3. **Confirma que las imágenes del carrusel estén en la carpeta `images/`**
4. **Revisa que los enlaces tengan la URL correcta**

### Formato esperado de `properties.json`:
```json
[
    {
        "id": "68af0e4f2d51c",
        "title": "villa en fuengirola",
        "price": 300200,
        "location": "fuengirola",
        "type": "Villa",
        "bedrooms": 0,
        "bathrooms": 3,
        "area": 388,
        "description": "una villa espectacular en fuengirola",
        "images": ["https://example.com/villa1.jpg"],
        "status": "active"
    }
]
```

## 🎉 RESULTADO FINAL

Después de seguir estos pasos, tendrás:
- ✅ Páginas de detalles funcionales para cada propiedad
- ✅ Galería de imágenes con miniaturas
- ✅ Información completa de cada propiedad
- ✅ Botones de contacto integrados
- ✅ Diseño responsive y profesional
- ✅ Navegación entre páginas funcionando

¡Tu cliente podrá ver todos los detalles de las propiedades en páginas separadas!
