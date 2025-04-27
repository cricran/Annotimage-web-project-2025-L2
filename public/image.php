<?php

if (!isset($_GET['image'])) {
    http_response_code(400);
    echo "Error: No image specified.";
    exit;
}

$imagePath = __DIR__ . '/../images/' . $_GET['image'];


if (!file_exists($imagePath)) {
    http_response_code(404);
    echo "Error: Image not found.";
    exit;
}

$fileType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));

if ($fileType == 'png') {
    $image = imagecreatefrompng($imagePath);
} elseif ($fileType == 'jpeg' || $fileType == 'jpg') {
    $image = imagecreatefromjpeg($imagePath);
} elseif ($fileType == 'webp') {
    $image = imagecreatefromwebp($imagePath);
} else {
    http_response_code(400);
    echo "Error: Unsupported image format.";
    exit;
}

if (!$image) {
    http_response_code(500);
    echo "Error: Failed to create image.";
    exit;
}

header('Content-Type: image/' . $fileType);
if ($fileType == 'png') {
    imagepng($image);
} elseif ($fileType == 'webp') {
    imagewebp($image);
} else {
    imagejpeg($image);
}
imagedestroy($image);
?>