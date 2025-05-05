<?php

// Renvoit un objet de base de donné connecter grâce aux informations de connection renseigné dans config.php
function connect_db () {
    include 'config.php';
    
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    return $db;
}

function disconnect_db (&$db) {
    $db = null;
}

// Notification

// Ajoute une nouvelle entité notification à la liste de notifications. La notification à un type à choisir entre "error", "success", "info" ou "warning" avec le titre $titre et un corps de message $message
function addNotification($type, $title, $message) {
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['notifications'])) {
        $_SESSION['notifications'] = [];
    }

    $_SESSION['notifications'][] = ['type' => $type, 'title' => $title, 'message' => $message];
}

// Renvoit la liste des notification. Toute les notifications sont supprimé après cette appele
function getNotifications() {
    if (!isset($_SESSION)) {
        session_start();
    }
    $notifications = $_SESSION['notifications'] ?? [];
    unset($_SESSION['notifications']);
    return $notifications;
}

// Images

// Créer une entité image avec l'image en elle même, ça description et tag si il y en a à partir de $info
function createImage($info) {?>
    <article id="<?= $info['id']?>">
        <div>
            <img src="/image.php?image=<?= $info['path']?>" alt="<?= $info['description']?>">
        </div>
        <h2><?= $info['description']?></h2>
        <p><a href="/index.php/user?user=<?= urlencode($info['name'])?>">@<?= $info['name']?></a></p>
        <p>
        <?php
        if (!empty($info['tags'])) {
            $tags = explode(',', $info['tags']);
        } else {
            $tags = [];
        }
        ?>
        <?php foreach($tags as $tag) : ?>
            <a href="/index.php/tag?tag=<?=urlencode($tag)?>">#<?=$tag?></a>
        <?php endforeach; ?>
        </p>
    </article>
<?php
}

// Affiche l'enssemble des images rensigné dans le tableau $info
function displayImages($infos) {
    if ($infos === []) {
        echo '<p>Aucune images à afficher</p>';
    }
    echo '<div class="grid">';
    foreach ($infos as $info) {
        createImage($info);
    }
    echo '</div>';
}

// Pages

// Créer la pagination de bas de page avec la page $page sélectionné en sachant qu'il y a $nbPage. Attribur représente le chemin relatif vers la page actuell et querry les éventuels éléments suplémentire à ajouter pour l'appele des prochaines pages
function createPageIndex($page, $nbPage, $attribut, $query) {
    if ($nbPage === 1) return;
    echo "<p>";
    for($i = 1; $i <= $nbPage; ++$i) {
        if ($i === $page) {
            echo "<a href='?$attribut=" . urlencode($query) . "&page=$i' class='page_select'>$i</a>";
        } else {
            echo "<a href='?$attribut=" . urlencode($query) . "&page=$i'>$i</a>";
        }
    }
    echo "</p>";
}


