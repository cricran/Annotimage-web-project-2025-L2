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
            <img src="/image.php?image=<?= $info['path']?>" alt="image">
        </div>
        <h2><?= $info['description']?></h2>
        <p><a href="/index.php/user?user=<?= $info['name']?>">@<?= $info['name']?></a></p>
        <p>
        <?php
        if (!empty($info['tags'])) {
            $tags = explode(',', $info['tags']);
        } else {
            $tags = [];
        }
        ?>
        <?php foreach($tags as $tag) : ?>
            <a href="/index.php/tag?tag=<?=$tag?>">#<?=$tag?></a>
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

// Pages

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


