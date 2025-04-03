<?php

function connect_db () {
    include_once 'config.php';
    
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    return $db;
}

function disconnect_db (&$db) {
    $db = null;
}

?>

