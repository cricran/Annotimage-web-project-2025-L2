<?php
function getImages($name) {
    header('Content-Type: image/png');
    $image = imagecreatefrompng('images/public' . $name);
    imagepng($image);
}

// getImages('image1.png');
?>

