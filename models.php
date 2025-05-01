<?php

function connect_db () {
    include 'config.php';
    
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    return $db;
}

function disconnect_db (&$db) {
    $db = null;
}

// Notification
function addNotification($type, $title, $message) {
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['notifications'])) {
        $_SESSION['notifications'] = [];
    }

    $_SESSION['notifications'][] = ['type' => $type, 'title' => $title, 'message' => $message];
}

function getNotifications() {
    if (!isset($_SESSION)) {
        session_start();
    }
    $notifications = $_SESSION['notifications'] ?? [];
    unset($_SESSION['notifications']);
    return $notifications;
}

function clearNotifications() {
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION['notifications'] = [];
}

// Images

function createImage($info) {?>
    <article>
        <div>
            <img src="image.php?image=<?= $info['path']?>" alt="image">
        </div>
        <h2><?= $info['description']?></h2>
        <p><a href="user.html?name=<?= $info['name']?>">@<?= $info['name']?></a></p>
        <p>
        <?php $tags = explode(',', $info['tags']); ?>
        <?php foreach($tags as $tag) : ?>
            <a href="tag.html?tag=<?=$tag?>">#<?=$tag?></a>
        <?php endforeach; ?>
        </p>
    </article>
<?php
}

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




