<?php $title = "Annotimage - Connexion"?>

<?php ob_start() ?>
    <div id="content">
        <section id="presentation">
            <img src="../static/images/favicon.png" alt="logo" height="50">
            <h2>Bienvenue sur Annotimage</h2>
            <ul>
                <li>Téléversser vos images</li>
                <li>Annoter vos images</li>
                <li>Rechercher et trier vos images</li>
                <li>Partager vos images</li>
                <li>Parcourir les images publiques</li>
            </ul>
        </section>
        <section id="login">
            <a href="<?php echo isset($_GET["callback"]) ? $_GET["callback"] : '/index.php' ?>"><img src="../static/images/close.svg" alt="close"></a>
            <h2>Se connecter</h2>
            <p>Vous n'avez pas de compte? <a href="/index.php/signup<?php echo '?callback=' . (isset($_GET['callback']) ? $_GET['callback'] : 'index.php'); ?>">s'inscrire</a></p>
            <form action="/index.php/signin" method="POST">
                <input type="hidden" name="callback" value="<?php echo isset($_GET['callback']) ? $_GET['callback'] : 'index.php'; ?>">
                <input type="text" placeholder="email ou pseudo" required name="email_pseudo">
                <input type="password" placeholder="mot de passe" required name="password">
                <button type="submit">Se connecter</button>
            </form>
        </section>
    </div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>