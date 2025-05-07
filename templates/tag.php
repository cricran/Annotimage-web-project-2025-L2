<?php $title = "Annotimage - tags"?>
<?php $callback = 'index.php/tag' . (urlencode($_GET['tag']) ?? '') ?>

<?php ob_start() ?>

    <?php include 'navbar.php'?>

    <section id="main">
        <img src="../static/images/tag.svg" alt="tag logo">
        <h2>#<?= $tag ?></h2>
    </section>

    <section id="image_grid">
        <?php displayImages($infos);?>
    </section>

    <section id="page_index">
        <?php createPageIndex($page, $totalPages, $attribut, $tag) ?>
    </section>

<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>