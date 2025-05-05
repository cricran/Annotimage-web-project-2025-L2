<?php
session_start();
include_once "../models.php";

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode([
        'error' => 'No image ID specified'
    ]);
    exit;
}



$bd = connect_db();
$r = $bd->prepare("
    SELECT image.*, username, email
    FROM image
    JOIN user ON user.id = image.userId
    WHERE image.id = :id AND (public = 1 OR userId = :sessionId)
");
$r->execute([
    ':id' => $_GET['id'],
    ':sessionId' => $_SESSION['user'] ?? ''
]);
if ($r->rowCount() !== 1) {
    http_response_code(403);
    echo json_encode([
        'error' => 'Image not found or access denied'
    ]);
    return;
}
$image = $r->fetch();



$r = $bd->prepare("
    SELECT tag.name
    FROM tag
    JOIN taged ON tag.id = taged.tagId
    WHERE taged.imageId = :id
");
$r->execute([':id' => $_GET['id']]);
$tags = $r->fetchAll();



$r = $bd->prepare("
    SELECT description, startX, startY, endX, endY
    FROM annotation
    WHERE imageId = :id
");
$r->execute([':id' => $_GET['id']]);
$annotations = $r->fetchAll();

$ownedByUser = isset($_SESSION['user']) && $_SESSION['user'] == $image['userId'];
$response = [
    'image' => [
        'id' => $image['id'],
        'path' => $image['path'],
        'description' => $image['description'],
        'public' => (bool)$image['public'],
        'date' => $image['date'],
        'user' => [
            'username' => $image['username'],
            'email' => $image['email']
        ]
    ],
    'tags' => $tags,
    'annotations' => $annotations,
    'is_owner' => $ownedByUser
];

// Envoi de la réponse
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);

disconnect_db($bd);