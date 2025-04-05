<?php

function home() {
    session_start();

    require 'templates/home.php';
}

function signup() {
    session_start();
    if(isset($_POST['email'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
        $password2 = htmlspecialchars($_POST['password2'], ENT_QUOTES, 'UTF-8');

        $issue = false;

        if (!filter_var($email, FILTER_SANITIZE_EMAIL)){
            addNotification('error', 'Erreur', 'Email invalide');
            $issue = true;
        }
        if ($password !== $password2) {
            addNotification('error', 'Erreur', 'Les mots de passe ne correspondent pas');
            $issue = true;
        }
        if (strlen($password) < 8) {
            addNotification('error', 'Erreur', 'Le mot de passe doit faire au moins 8 caractères');
            $issue = true;
        }
        if (strlen($username) < 3) {
            addNotification('error', 'Erreur', 'Le pseudo doit faire au moins 3 caractères');
            $issue = true;
        }
        if (strlen($username) > 64) {
            addNotification('error', 'Erreur', 'Le pseudo doit faire au plus 64 caractères');
            $issue = true;
        }
        if (strlen($email) > 255) {
            addNotification('error', 'Erreur', 'L\'email doit faire au plus 255 caractères');
            $issue = true;
        }
        if ($issue) {
            require 'templates/signup.php';
            return;
        }

        $bd = connect_db();
        $r_email = $bd->prepare("SELECT * FROM user WHERE email = :email");
        $r_email->execute([':email' => $email]);
        if (!$r_email) {
            addNotification('error', 'Erreur', 'Erreur lors de la vérification de l\'email');
            require 'templates/signup.php';
            return;
        }
        if ($r_email->rowCount() > 0) {
            addNotification('error', 'Erreur', 'Cet email est déjà utilisé');
            require 'templates/signup.php';
            return;
        }
        $r_username = $bd->prepare("SELECT * FROM user WHERE username = :username");
        $r_username->execute([':username' => $username]);
        if (!$r_username) {
            addNotification('error', 'Erreur', 'Erreur lors de la vérification du pseudo');
            require 'templates/signup.php';
            return;
        }
        if ($r_username->rowCount() > 0) {
            addNotification('error', 'Erreur', 'Ce pseudo est déjà utilisé');
            require 'templates/signup.php';
            return;
        }
        $password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $bd->prepare("INSERT INTO user (email, username, password) VALUES (:email, :username, :password)");
        $stmt->execute([':email' => $email, ':username' => $username, ':password' => $password]);
        if (!$stmt) {
            addNotification('error', 'Erreur', 'Erreur lors de l\'inscription');
            require 'templates/signup.php';
            return;
        }
        disconnect_db($bd);
        addNotification('success', 'Succès', 'Inscription réussie');

        if (isset($_POST['callback'])) {
            header('Location: /' . $_POST['callback']);
        } else {
            header('Location: index.php');
        }
        exit();
    }

    require 'templates/signup.php';
}

function signin() {
    require 'templates/signin.php';
}

?>