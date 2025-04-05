<?php $title = "Annotimage - Acceuille"?>
<?php $callback = 'index.php' ?>

<?php ob_start() ?>

    <div id="center">
        <div id="upload">
            <a href="/html/"><img src="../static/images/close.svg" alt="close"></a>
            <h2>Ajouter une image</h2>
            <form action="" id="form">
                <div>
                    <input type="file" accept="image/*" onchange="previewImage()">
                    <br>
                    <img id="imagePreview" src="" alt="Image Preview" style="display:none; max-width: 100%;" />
                </div>

                <div>
                    <input type="text" placeholder="Description">

                    <input type="text" placeholder="Ajouter des tags">
                    <div id="selected_tag" style="display: block;">
                        <div>
                            <span>#cinema</span>
                            <button><img src="../static/images/close.svg" alt="suprimer"></button>
                        </div>
                        <div>
                            <span>#cinema</span>
                            <button><img src="../static/images/close.svg" alt="suprimer"></button>
                        </div>

                    </div>
                    <!-- <select name="" id="">
                        <option value="">Ajouter dans une collection</option>
                        <option value="dog">Dog</option>
                        <option value="cat">Cat</option>
                        <option value="hamster">Hamster</option>
                        <option value="parrot">Parrot</option>
                        <option value="spider">Spider</option>
                        <option value="goldfish">Goldfish</option>
                    </select> -->
                    <input type="submit" value="envoyer">
                </div>

            </form>
        </div>
    </div>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>