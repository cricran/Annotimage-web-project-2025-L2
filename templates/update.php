<?php $title = "Annotimage - Mise à Jour"?>
<?php $callback = '/index.php/update' ?>
<?php $script = '../static/js/update.js' ?>

<?php ob_start() ?>

    <div id="center">
        <div id="upload">
            <a href="/<?php echo isset($_GET["callback"]) ? $_GET["callback"] : 'index.php' ?>"><img src="../static/images/close.svg" alt="close"></a>
            <h2>Mofifier une image</h2>
            <form action="" id="form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="callback" value="<?php echo isset($_GET['callback']) ? $_GET['callback'] : 'index.php'; ?>">
                <input type="hidden" name="id" id="id" value="<?=$id?>">
                
                <div>
                    <img id="image_selected" src="/image.php?image=<?=$path?>" alt="Image" />
                </div>
                <div>
                    <textarea type="text" placeholder="Description" name="description" required><?= $description ?></textarea>
                    <div id="tags">
                        <input type="text" placeholder="Ajouter des tags" id="name_add_tag">
                        <input type="button" value="+" id="add_tag">
                    </div>
                    <div id="selected_tag">
                    </div>
                    <p>Rendre votre image public : <input type="checkbox" name="public" id="public" <?= $public == 1 ? 'checked' : '' ?>></p>
                    
                    <input type="submit" name="update" value="Modifier">
                </div>
            </form>
        </div>
    </div>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>