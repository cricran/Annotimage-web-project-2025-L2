<?php $title = "Annotimage - Acceuille"?>
<?php $callback = 'index.php' ?>

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

<!-- <dialog id="showImg">
    <div>
        <img src="/image.php?image=40.jpeg" usemap="#image-map" alt="image">
        <div id="tooltip"></div>
        <div>
            <h2>Une image du film Dune (2021)</h2>
            <p>Utilisateur : @myuser</p>
            <p>Tags : #cinema, #film, #dune</p>
        </div>
    </div>
    <div>
        <p>Image :</p>
        <a href=""><img src="../static/images/edit.svg" alt=""></a>
        <a href=""><img src="../static/images/del.svg" alt=""></a>
        <p>Annotation :</p>
        <a href=""><img src="../static/images/edit.svg" alt=""></a>
        <a href=""><img src="../static/images/show.svg" alt=""></a>
    </div>
</dialog> -->

<script>
    window.addEventListener('scroll', function () {
        const searchBar = document.getElementById('searchBarTop');
        if (window.scrollY > 300) {
            searchBar.classList.add('show');
        } else {
            searchBar.classList.remove('show');
        }
    });

</script>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>