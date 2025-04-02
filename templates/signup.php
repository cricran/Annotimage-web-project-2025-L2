<?php $title = "Annotimage - Inscription"?>

<?php ob_start() ?>
    <div id="content">
        <section id="presentation">
            <img src="../static/images/logo_min.png" alt="logo">
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
            <a href="/index.php"><img src="../static/images/close.svg" alt="close"></a>
            <h2>S'inscrire</h2>
            <p>Vous avez déjas un compte? <a href="/index.php/signin">se connecter</a></p>
            <form action="/toto">
                <input type="email" placeholder="email">
                <input type="text" placeholder="pseudo">
                <input type="password" placeholder="mot de passe">
                <input type="password" placeholder="vérifier votre mot de passe">
                <button type="submit">S'inscrire</button>
            </form>
        </section>
    </div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>