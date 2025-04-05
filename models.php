<?php

function connect_db () {
    include_once 'config.php';
    
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

?>

