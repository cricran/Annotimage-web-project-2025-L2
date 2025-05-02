<?php
session_start();
include_once "../models.php";

ini_set('display_errors', '1');
error_reporting(E_ALL);

if (!isset($_GET['image'])) {
    http_response_code(400);
    echo "Error: No image specified.";
    exit;
}

$bd = connect_db();

$r = $bd->prepare("
    SELECT *
    FROM image
    WHERE
        path = :path and
        public = 1 or userId = :id
");

$r->execute([
    'id' => $_SESSION['user'] ?? '',
    'path' => $_GET['image']
]);

if ($r->rowCount() <= 0) {
    http_response_code(403);
    echo "Error: You do not have acces to this ressource";
    exit;
}

disconnect_db($bd);


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