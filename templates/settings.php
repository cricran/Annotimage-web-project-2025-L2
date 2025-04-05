<?php $title = "Annotimage - Settings"?>
<?php $script = "../static/js/settings.js" ?>

<?php ob_start() ?>
    <div id="setting_page">
    <a href="/<?php echo isset($_GET["callback"]) ? $_GET["callback"] : 'index.php' ?>"><img src="../static/images/close.svg" alt="close"></a>
    <section>
            <h2>Paramètres</h2>
            <p>Vous pouvez modifier vos paramètres ici.</p>
            <form id="account" action="/index.php/settings?callback=<?php echo isset($_GET["callback"]) ? $_GET["callback"] : 'index.php' ?>" method="POST">
                <input type="text" placeholder="pseudo" required name="username" maxlength="64" value="<?php echo $_SESSION['username'] ?>">
                <input type="email" placeholder="email" required name="email" maxlength="255" value="<?php echo $_SESSION['email'] ?>">
                <input type="password" placeholder="nouveau mot de passe" name="password">
                <input type="password" placeholder="vérifier votre nouveau mot de passe" name="password2">
                <button type="submit" name="modif">Modifier</button>
            </form>
        </section>
        <section>
            <h2>Supprimer mon compte</h2>
            <p>Si vous souhaitez supprimer votre compte, vous pouvez le faire ici. Cela supprimera toutes vos images et annotations.</p>
            <form id="delete" action="/index.php/settings?callback=<?php echo isset($_GET["callback"]) ? $_GET["callback"] : 'index.php' ?>" method="POST">
                <button type="submit" class="sup" name="delete">Supprimer mon compte</button>
            </form>
        </section>
        <section>
            <h2>Déconnexion</h2>
            <p>Si vous souhaitez vous déconnecter, vous pouvez le faire ici.</p>
            <form id="logout" action="/index.php/settings?callback=<?php echo isset($_GET["callback"]) ? $_GET["callback"] : 'index.php' ?>" method="POST">
                <input type="hidden" name="logout" value="true">
                <button type="submit" class="sup">Déconnexion</button>
            </form>
    </div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>