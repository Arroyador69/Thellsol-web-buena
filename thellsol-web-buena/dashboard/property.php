<?php
require_once '../config.php';
require_once 'auth.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Propiedad no especificada.');
}
$property_id = intval($_GET['id']);

// Obtener datos de la propiedad
$stmt = $pdo->prepare('SELECT * FROM properties WHERE id = ?');
$stmt->execute([$property_id]);
$property = $stmt->fetch();
if (!$property) {
    die('Propiedad no encontrada.');
}
// Obtener imágenes adicionales
$stmt = $pdo->prepare('SELECT * FROM property_images WHERE property_id = ?');
$stmt->execute([$property_id]);
$images = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($property['title']) ?> - ThellSol Real Estate</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="../logo-thellsol copia.png" type="image/png">
    <style>
        body { font-family: 'Cormorant Garamond', serif; background: #f5f7fa; color: #333; }
        .container { max-width: 900px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 12px #0002; padding: 32px; }
        .title { font-size: 2.2rem; font-weight: 700; color: #181e29; margin-bottom: 10px; }
        .price { font-size: 1.5rem; color: #28a745; font-weight: 600; margin-bottom: 18px; }
        .main-image { width: 100%; max-height: 400px; object-fit: cover; border-radius: 12px; margin-bottom: 18px; }
        .gallery { display: flex; gap: 12px; margin-bottom: 18px; flex-wrap: wrap; }
        .gallery img { width: 120px; height: 90px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px #0001; }
        .details { margin-bottom: 18px; }
        .details strong { display: inline-block; min-width: 120px; color: #181e29; }
        .features { margin-bottom: 18px; }
        .features span { background: #f0f0f0; color: #333; border-radius: 6px; padding: 6px 12px; margin: 0 6px 6px 0; display: inline-block; font-size: 0.98rem; }
        .desc { margin-bottom: 18px; color: #444; }
        .back-btn { display: inline-block; background: #181e29; color: #fff; text-decoration: none; padding: 10px 22px; border-radius: 7px; font-weight: bold; font-size: 1.08rem; transition: background 0.2s; box-shadow: 0 2px 8px #0001; }
        .back-btn:hover { background: #232a3a; }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-btn"><i class="fa fa-arrow-left"></i> Volver al Dashboard</a>
        <h1 class="title"><?= htmlspecialchars($property['title']) ?></h1>
        <div class="price">€<?= number_format($property['price'], 0, ',', '.') ?></div>
        <?php if (!empty($property['main_image'])): ?>
            <img src="../<?= htmlspecialchars($property['main_image']) ?>" alt="Imagen principal" class="main-image" />
        <?php endif; ?>
        <?php if ($images): ?>
        <div class="gallery">
            <?php foreach ($images as $img): ?>
                <img src="../<?= htmlspecialchars($img['image_path']) ?>" alt="Imagen galería" />
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="details">
            <p><strong>Ubicación:</strong> <?= htmlspecialchars($property['location']) ?></p>
            <p><strong>Tipo:</strong> <?= htmlspecialchars($property['type']) ?></p>
            <p><strong>Dormitorios:</strong> <?= htmlspecialchars($property['bedrooms']) ?></p>
            <p><strong>Baños:</strong> <?= htmlspecialchars($property['bathrooms']) ?></p>
            <p><strong>Superficie:</strong> <?= htmlspecialchars($property['area']) ?> m²</p>
            <p><strong>Estado:</strong> <?= htmlspecialchars($property['status']) ?></p>
        </div>
        <div class="features">
            <?php if (!empty($property['features'])):
                $features = explode(',', $property['features']);
                foreach ($features as $f): ?>
                <span><?= htmlspecialchars(trim($f)) ?></span>
            <?php endforeach; endif; ?>
        </div>
        <div class="desc">
            <?= nl2br(htmlspecialchars($property['description'])) ?>
        </div>
    </div>
</body>
</html> 