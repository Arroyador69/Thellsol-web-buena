<?php
// Propiedades reales del dashboard - Actualizar manualmente
// Archivo: propiedades-dashboard.php

// IMPORTANTE: Cada vez que crees una propiedad en el dashboard, 
// añádela aquí para que aparezca en la web

$propiedadesDashboard = [
    // AÑADE AQUÍ LAS PROPIEDADES QUE CREES EN EL DASHBOARD
    // Copia y pega los datos exactos del dashboard
    
    // Ejemplo de formato:
    /*
    [
        'id' => 'ID_DE_LA_PROPIEDAD',
        'title' => 'Título de la propiedad',
        'price' => 500000,
        'location' => 'fuengirola',
        'type' => 'villa',
        'bedrooms' => 3,
        'bathrooms' => 2,
        'area' => 150,
        'status' => 'active',
        'images' => '["URL_DE_LA_IMAGEN"]'
    ],
    */
];

// Función para obtener propiedades
function getDashboardProperties() {
    global $propiedadesDashboard;
    return $propiedadesDashboard;
}

// Función para mostrar propiedades
function displayDashboardProperties($properties) {
    if (empty($properties)) {
        echo '<p style="text-align: center; padding: 20px; color: #666;">No hay propiedades disponibles en el dashboard.</p>';
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
?>
