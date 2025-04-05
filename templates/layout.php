<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/style.css">
    <link rel="icon" type="image/png" href="../static/images/favicon.png">
    <script src="http://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../static/js/code.js" defer></script>
    <title><?php $title ?></title>
</head>
<body>
    <?= $content ?>
    <?php include "notification.php"?>
</body>
</html>