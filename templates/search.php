<?php $title = "Annotimage - tags"?>

<?php ob_start() ?>

    <?php include 'navbar.php'?>

    <section id="search">
        <h1>Rechercher des images</h1>
        <form action="">
            <input type="search" placeholder="Images, #tags, @utilisateurs" id="q" name="q" value="<?= $_GET['q'] ?? '' ?>">
        </form>
    </section>

    <section id="image_grid">
        <?php displayImages($infos);?>
    </section>

    <section id="page_index">
        <?php createPageIndex($page, $totalPages, $attribut, $query) ?>
    </section>

<?php $content = ob_get_clean() ?>
<?php include 'layout.php' ?>