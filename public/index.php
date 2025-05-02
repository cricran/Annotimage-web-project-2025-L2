<?php

require_once __DIR__ . '/../models.php';
require_once __DIR__ . '/../controllers.php';
require_once __DIR__ . '/../debug.php';

$GLOBALS['notifications'] = [];

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($request == '/index.php' || $request == '/') {
    home();
} elseif ($request == '/index.php/signup') {
    signup();
} elseif ($request == '/index.php/signin') {
    signin();
} elseif ($request == '/index.php/settings') {
    settings();
} elseif ($request == '/index.php/search') {
    search();
} elseif ($request == '/index.php/upload') {
    upload();
} elseif ($request == '/index.php/tag') {
    tag();
} elseif ($request == '/index.php/user') {
    user();
} else {
    header('HTTP/1.1 404 Not Found');
    echo '<html><body><h1>Page introuvable</h1></body></html>';
}

?>