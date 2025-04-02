<?php
$request = trim($_SERVER['REQUEST_URI'], '/');

// Supprime "index.php" s'il est présent dans l'URL
$request = preg_replace('/^index\.php\/?/', '', $request);

if ($request == '' || $request == 'accueil') {
    echo "Page d'accueil";
} elseif ($request == 'test/toto') {
    echo "Affichage d'un tototoot";
} elseif ($request == 'billet') {
    echo "Affichage d'un billet";
} else {
    echo "Page non trouvée";
}
