<?php $title = "Annotimage - utilisateur"?>

<?php ob_start() ?>

    <?php include 'navbar.php'?>

    <section id="main">
        <img src="../static/images/user.svg" alt="user logo">
        <h2>@<?= $user ?></h2>
    </section>

    <section id="image_grid">
        <?php displayImages($infos);?>
    </section>

    <section id="page_index">
        <?php createPageIndex($page, $totalPages, $attribut, $user) ?>
    </section>

<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>