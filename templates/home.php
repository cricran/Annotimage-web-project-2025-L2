<?php $title = "Annotimage - Acceuille"?>
<?php $callback = 'index.php' ?>
<?php $script = '../static/js/home.js' ?>

<?php ob_start() ?>

<?php include 'navbar.php'?>


<section id="main">
    <h1>Téléversez et Annotez vos images</h1>
    <form action="/index.php/search">
        <input type="search" placeholder="Images, #tags, @utilisateurs" id="q" name="q">
    </form>
    <a href="index.php/upload?callback=index.php">
        Nouveau post
        <img src="../static/images/upload.svg" alt="upload">
    </a>
</section>

<section id="image_grid">
    <h2>Les images les plus récentes</h2>
    <?php displayImages($infos);?>
</section>

<a href="/index.php/search" class="seeMore">Voir plus d'images</a>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>