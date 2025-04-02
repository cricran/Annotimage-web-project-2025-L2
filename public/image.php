<?php

if (!isset($_GET['image'])) {
    http_response_code(400); // Bad Request
    echo "Error: No image specified.";
    exit;
}

$imagePath = __DIR__ . '/../images/public/' . $_GET['image'];

// Vérife si fichier existe
if (!file_exists($imagePath)) {
    http_response_code(404);
    echo "Error: Image not found.";
    exit;
}


$image = imagecreatefrompng($imagePath);
if (!$image) {
    http_response_code(500);
    echo "Error: Failed to create image.";
    exit;
}

header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?>