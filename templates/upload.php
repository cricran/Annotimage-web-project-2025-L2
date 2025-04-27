<?php $title = "Annotimage - Acceuille"?>
<?php $callback = 'index.php' ?>
<?php $script = '../static/js/upload.js' ?>

<?php ob_start() ?>

    <div id="center">
        <div id="upload">
            <a href="/<?php echo isset($_GET["callback"]) ? $_GET["callback"] : 'index.php' ?>"><img src="../static/images/close.svg" alt="close"></a>
            <h2>Ajouter une image</h2>
            <form action="/index.php/upload" id="form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="callback" value="<?php echo isset($_GET['callback']) ? $_GET['callback'] : 'index.php'; ?>">
                <div>
                    <img id="imagePreview" src="../static/images/no_image.svg" alt="Image Preview"/>
                    <br>
                    <input type="file" accept="image/png, image/jpeg, image/jpg, image/webp" id="fileInput" name="fileInput">
                </div>
                <div>
                    <input type="text" placeholder="Description" name="description" required>
                    <div id="tags">
                        <input type="text" placeholder="Ajouter des tags" id="name_add_tag">
                        <input type="button" value="+" id="add_tag">
                    </div>
                    <div id="selected_tag">
                    </div>
                    <p>Rendre votre image public : <input type="checkbox" name="public" id="public"></p>
                    
                    <input type="submit" name="envoyer" value="envoyer">
                </div>

            </form>
        </div>
    </div>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>