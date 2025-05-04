<?php
session_start();
include_once "../models.php";

if (!isset($_SESSION['user'])) {
    addNotification('error', 'Erreur', 'Vous devez être connecté pour supprimer une image');
    if (isset($_GET['callback'])) {
        header('Location: /' . $_GET['callback']);
    } else {
        header('Location: /index.php');
    }
    return;
}

if (!isset($_GET['id'])) {
    addNotification('error', 'Erreur', 'Aucune image spécifiée');
    if (isset($_GET['callback'])) {
        header('Location: /' . $_GET['callback']);
    } else {
        header('Location: /index.php');
    }
    return;
}

$bd = connect_db();

$r = $bd->prepare("
    SELECT path
    FROM image
    WHERE id = :id AND userId = :userId
");
$r->execute([
    ':id' => $_GET['id'],
    ':userId' => $_SESSION['user']
]);
if ($r->rowCount() !== 1) {
    addNotification('error', 'Erreur', 'Image introuvable ou accès refusé');
    header('Location: /index.php');
    disconnect_db($bd);
    exit;
}

$image = $r->fetch();
$imagePath = __DIR__ . '/../images/' . $image['path'];

if (file_exists($imagePath)) {
    unlink($imagePath);
}
$r = $bd->prepare("DELETE FROM image WHERE id = :id AND userId = :userId");
$success = $r->execute([
    ':id' => $_GET['id'],
    ':userId' => $_SESSION['user']
]);
disconnect_db($bd);

if ($success) {
    addNotification('success', 'Succès', 'Image supprimée avec succès');
} else {
    addNotification('error', 'Erreur', 'Erreur lors de la suppression de l\'image');
}
if (isset($_GET['callback'])) {
    header('Location: /' . $_GET['callback']);
} else {
    header('Location: /index.php');
}
return;