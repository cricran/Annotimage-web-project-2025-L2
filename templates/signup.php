<?php $title = "Annotimage - Inscription"?>

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
            <a href="/<?php echo isset($_GET["callback"]) ? $_GET["callback"] : 'index.php' ?>"><img src="../static/images/close.svg" alt="close"></a>
            <h2>S'inscrire</h2>
            <p>Vous avez déjas un compte? <a href="/index.php/signin<?php echo '?callback=' . (isset($_GET['callback']) ? $_GET['callback'] : 'index.php'); ?>">se connecter</a></p>
            <form action="/index.php/signup" method="post">
                <input type="email" placeholder="email" required name="email" maxlength="255">
                <input type="text" placeholder="pseudo" required name="username" maxlength="64">
                <input type="password" placeholder="mot de passe" required name="password">
                <input type="password" placeholder="vérifier votre mot de passe" required name="password2">
                <input type="hidden" name="callback" value="<?php echo isset($_GET['callback']) ? $_GET['callback'] : 'index.php'; ?>">
                <button type="submit">S'inscrire</button>
            </form>
        </section>
    </div>
<?php $content = ob_get_clean(); ?>

<?php include 'layout.php' ?>