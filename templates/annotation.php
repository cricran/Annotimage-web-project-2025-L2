<?php $title = "Annotimage - Annotation"?>
<?php $callback = 'index.php' ?>
<?php $script = '../static/js/annotation.js' ?>

<?php ob_start() ?>

    <div id="center">
        <div id="annote">
        <a href="/<?php echo isset($_GET["callback"]) ? $_GET["callback"] : 'index.php' ?>"><img src="../static/images/close.svg" alt="close"></a>

            <h2>Ajouter des annotationa en sélectionnant une zonne sur l'image</h2>
            <form action="" id="form" method="POST">
                <input type="hidden" name="callback" value="<?php echo isset($_GET['callback']) ? $_GET['callback'] : 'index.php'; ?>">
                <input type="hidden" name="id" id="id" value="<?=$id?>">
                <div id="image_area">
                    <img id="image_selected" src="/image.php?image=<?=$path?>" alt="Image" />
                </div>

                <div id="annote_form">
                    <p>List de vos annotation :</p>
                    <div id="annote_area">
                    </div>
                    <input type="submit" name="envoyer" value="valider">
                </div>
            </form>
        </div>
    </div>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>