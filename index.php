<?php
$uri = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");

if ($uri === "") {
    echo "<html><body><h1>Home</h1></body></html>";
} elseif ($uri === "test" && isset($_GET["id"])) {
    echo "<html><body><h1>Page test</h1><p>{$_GET['id']}</p></body></html>";
} else {
    header("HTTP/1.1 404 Not Found");
    echo "<html><body><h1>Page introuvable</h1></body></html>";
}
?>
