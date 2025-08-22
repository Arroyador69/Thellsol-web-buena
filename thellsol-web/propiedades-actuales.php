<?php
// Propiedades actuales del dashboard - Versión estática pero actualizable
// Archivo: propiedades-actuales.php

// Datos de las propiedades del dashboard (actualizados manualmente)
$propiedades = [
    [
        'id' => 1,
        'title' => 'Villa preciosa',
        'price' => 340000,
        'location' => 'fuengirola',
        'type' => 'villa',
        'bedrooms' => 4,
        'bathrooms' => 3,
        'area' => 250,
        'status' => 'active',
        'images' => '["https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"]'
    ],
    [
        'id' => 2,
        'title' => 'Elegante Villa con Vistas Espectaculares - Junto al Castillo Sohail, Fuengirola',
        'price' => 1350000,
        'location' => 'fuengirola',
        'type' => 'villa',
        'bedrooms' => 5,
        'bathrooms' => 4,
        'area' => 350,
        'status' => 'active',
        'images' => '["https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"]'
    ],
    [
        'id' => 3,
        'title' => 'Villa moderna en Benalmádena',
        'price' => 850000,
        'location' => 'benalmadena',
        'type' => 'villa',
        'bedrooms' => 4,
        'bathrooms' => 3,
        'area' => 280,
        'status' => 'active',
        'images' => '["https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"]'
    ],
    [
        'id' => 4,
        'title' => 'Apartamento de lujo en Fuengirola',
        'price' => 350000,
        'location' => 'fuengirola',
        'type' => 'apartment',
        'bedrooms' => 3,
        'bathrooms' => 2,
        'area' => 120,
        'status' => 'active',
        'images' => '["https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"]'
    ],
    [
        'id' => 5,
        'title' => 'Villa con Piscina en Fuengirola',
        'price' => 650000,
        'location' => 'fuengirola',
        'type' => 'villa',
        'bedrooms' => 4,
        'bathrooms' => 3,
        'area' => 250,
        'status' => 'active',
        'images' => '["https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"]'
    ],
    [
        'id' => 6,
        'title' => 'Chalet Moderno en Benalmádena',
        'price' => 850000,
        'location' => 'benalmadena',
        'type' => 'chalet',
        'bedrooms' => 5,
        'bathrooms' => 4,
        'area' => 300,
        'status' => 'active',
        'images' => '["https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"]'
    ]
];

// Función para mostrar propiedades
function displayProperties($properties) {
    if (empty($properties)) {
        echo '<p>No hay propiedades disponibles.</p>';
        return;
    }
    
    foreach ($properties as $property) {
        $images = json_decode($property['images'], true);
        $mainImage = !empty($images) ? $images[0] : 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
        
        echo '<div class="card">';
        echo '<img src="' . htmlspecialchars($mainImage) . '" class="card-img" alt="' . htmlspecialchars($property['title']) . '">';
        echo '<div class="card-body">';
        echo '<h3 class="card-title">' . htmlspecialchars($property['title']) . '</h3>';
        echo '<p class="card-zona">' . htmlspecialchars($property['location']) . '</p>';
        echo '<p class="card-desc">';
        $desc = [];
        if ($property['bedrooms']) $desc[] = $property['bedrooms'] . ' dormitorios';
        if ($property['bathrooms']) $desc[] = $property['bathrooms'] . ' baños';
        if ($property['area']) $desc[] = $property['area'] . 'm²';
        echo implode(', ', $desc);
        echo '</p>';
        echo '<p class="card-precio">' . number_format($property['price']) . '€</p>';
        echo '<button class="card-btn">Ver Detalles</button>';
        echo '</div>';
        echo '</div>';
    }
}

// Función para obtener propiedades (para usar en otras páginas)
function getProperties() {
    global $propiedades;
    return $propiedades;
}
?>
