<?php

require_once 'models.php';
require_once 'controllers.php';
require_once 'debug.php';

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($request == '/index.php' || $request == '/') {
    home();
} elseif ($request == 'test/toto') {
    echo "Affichage d'un tototoot";
} elseif ($request == 'billet') {
    echo "Affichage d'un billet";
} else {
    header('HTTP/1.1 404 Not Found');
    echo '<html><body><h1>Page introuvable</h1></body></html>';
}

?>