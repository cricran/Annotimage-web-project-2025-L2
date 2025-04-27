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
        $r_user = $bd->prepare("INSERT INTO user (email, username, password) VALUES (:email, :username, :password)");
        $r_user->execute([':email' => $email, ':username' => $username, ':password' => $password]);
        if (!$r_user) {
            addNotification('error', 'Erreur', 'Erreur lors de l\'inscription');
            require 'templates/signup.php';
            return;
        }
        disconnect_db($bd);
        $callback = isset($_POST['callback']) ? $_POST['callback'] : 'index.php';
        addNotification('success', 'Succès', 'Inscription réussie ! Vous <a href="/index.php/signin?callback=' . $callback . '">pouvez vous connecter</a> maintenant');

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
    session_start();


    if(isset($_POST['email_pseudo'])) {
        session_regenerate_id(); 

        $email_pseudo = htmlspecialchars($_POST['email_pseudo'], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

        $bd = connect_db();
        $r_user = $bd->prepare("SELECT * FROM user WHERE email = :email OR username = :username");
        $r_user->execute([':email' => $email_pseudo, ':username' => $email_pseudo]);
        if (!$r_user) {
            addNotification('error', 'Erreur', 'Erreur lors de la vérification de l\'email ou du pseudo');
            require 'templates/signin.php';
            return;
        }
        if ($r_user->rowCount() != 1) {
            addNotification('error', 'Erreur', 'Email ou pseudo incorrect');
            require 'templates/signin.php';
            return;
        }
        $user = $r_user->fetch();
        if (!password_verify($password, $user['password'])) {
            addNotification('error', 'Erreur', 'Mot de passe incorrect');
            require 'templates/signin.php';
            return;
        }

        $_SESSION['user'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];

        disconnect_db($bd);
        addNotification('info', 'Information', 'Connexion réussie');
        
        if (isset($_POST['callback'])) {
            header('Location: /' . $_POST['callback']);
        } else {
            header('Location: index.php');
        }
        exit();
    }


    require 'templates/signin.php';
}

function settings() {
    session_start();
    if (!isset($_SESSION['user'])) {
        addNotification('error', 'Erreur', 'Vous devez être connecter pour accéder à cette page');
        header('Location: /index.php');
        return;
    }

    if (isset($_POST['logout'])) {
        session_regenerate_id(); 
        addNotification('info', 'Information', 'Déconnexion réussie');
        $_SESSION['user'] = null;
        header('Location: /index.php');
        return;
    }

    if (isset($_POST['modif'])) {
        $pseudo = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
        $password2 = htmlspecialchars($_POST['password2'], ENT_QUOTES, 'UTF-8');
        $issue = false;

        if (!empty($email) && $email !== $_SESSION['email']) {
            if (!filter_var($email, FILTER_SANITIZE_EMAIL)){
                addNotification('error', 'Erreur', 'Email invalide');
                require 'templates/settings.php';
                return;
            }
            $bd = connect_db();
            $r_update = $bd->prepare("UPDATE user SET email = :email WHERE id = :id");
            $r_update->execute([':email' => $email, ':id' => $_SESSION['user']]);
            if (!$r_update) {
                addNotification('error', 'Erreur', 'Erreur lors de la mise à jour de l\'email');
                require 'templates/settings.php';
                return;
            }
            $_SESSION['email'] = $email;
            addNotification('info', 'Information', 'Email mis à jour avec succès');
        }

        if (!empty($pseudo) && $pseudo !== $_SESSION['username']) {
            if (strlen($pseudo) < 3) {
                addNotification('error', 'Erreur', 'Le pseudo doit faire au moins 3 caractères');
                require 'templates/settings.php';
                return;
            }
            if (strlen($pseudo) > 64) {
                addNotification('error', 'Erreur', 'Le pseudo doit faire au plus 64 caractères');
                require 'templates/settings.php';
                return;
            }
            $bd = connect_db();
            $r_update = $bd->prepare("UPDATE user SET username = :username WHERE id = :id");
            $r_update->execute([':username' => $pseudo, ':id' => $_SESSION['user']]);
            if (!$r_update) {
                addNotification('error', 'Erreur', 'Erreur lors de la mise à jour du pseudo');
                require 'templates/settings.php';
                return;
            }
            $_SESSION['username'] = $pseudo;
            addNotification('info', 'Information', 'Pseudo mis à jour avec succès');
        }
        if (!empty($password)) {
            if (strlen($password) < 8) {
                addNotification('error', 'Erreur', 'Le mot de passe doit faire au moins 8 caractères');
                require 'templates/settings.php';
                return;
            }
            if ($password !== $password2) {
                addNotification('error', 'Erreur', 'Les mots de passe ne correspondent pas');
                require 'templates/settings.php';
                return;
            }
            $bd = connect_db();
            $password = password_hash($password, PASSWORD_BCRYPT);
            $r_update = $bd->prepare("UPDATE user SET password = :password WHERE id = :id");
            $r_update->execute([':password' => $password, ':id' => $_SESSION['user']]);
            if (!$r_update) {
                addNotification('error', 'Erreur', 'Erreur lors de la mise à jour du mot de passe');
                require 'templates/settings.php';
                return;
            }
            addNotification('info', 'Information', 'Mot de passe mis à jour avec succès');
        }
        if ((empty($password) && empty($email) && empty($pseudo)) ||(empty($password) && $email === $_SESSION['email'] && $pseudo === $_SESSION['username'])) {
            addNotification('warning', 'Attention', 'Veuillez modifier au moins un champ pour applique une modification');
            require 'templates/settings.php';
            return;
        }    
    }

    if (isset($_POST['delete'])) {
        $bd = connect_db();
        $r_delete = $bd->prepare("DELETE FROM user WHERE id = :id");
        $r_delete->execute([':id' => $_SESSION['user']]);
        if (!$r_delete) {
            addNotification('error', 'Erreur', 'Erreur lors de la suppression du compte');
            require 'templates/settings.php';
            return;
        }
        $_SESSION['user'] = null;
        addNotification('info', 'Information', 'Compte supprimé avec succès');
        header('Location: /index.php');
        return;
    }

    require 'templates/settings.php';
}

function profile() {
    session_start();
    addNotification('error', 'Erreur', 'Cette page est encore en construction');
    header('Location: /index.php');
    exit();
}

function upload() {
    session_start();
    if (!isset($_SESSION['user'])) {
        addNotification('error', 'Erreur', 'Vous devez être connecter pour ajouter une image');
        header('Location: /index.php');
        return;
    }
    if (isset($_POST['envoyer'])) {
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
        $issue = false;

        if (strlen($description) > 1024) {
            addNotification('error', 'Erreur', 'La description doit faire au plus 1024 caractères');
            $issue = true;
        }
        if (strlen($description) < 5) {
            addNotification('error', 'Erreur', 'La description doit faire au moins 5 caractères');
            $issue = true;
        }
        if (!isset($_FILES['fileInput'])) {
            addNotification('error', 'Erreur', 'Vous devez fournir une image valide');
            $issue = true;
        } else {
            if ($_FILES['fileInput']['error'] !== UPLOAD_ERR_OK) {
                addNotification('error', 'Erreur', 'L\'image n\'as pas put être ajouté');
                $issue = true;
            }
            if (preg_match('#^[a-z]+/([a-z0-9\-\.\+]+)$#i', $_FILES['fileInput']['type'], $f_type)) {
                $f_type =  $f_type[1];
            }
            if ($f_type !== 'png' && $f_type !== 'jpeg' && $f_type !== 'jpg' && $f_type !== 'webp') {
                addNotification('error', 'Erreur', 'L\'image doit être aux format suivant : png, jpeg (jpeg) ou webp. Vous aves donné : ' . $f_type);
                $issue = true;
            }
        }
        if ($issue) {
            require 'templates/upload.php';
            return;
        }

        $bd = connect_db();
        #Ajout de l'image à la bd
        $r = $bd->prepare("INSERT INTO image (path, description, public, date, userid) VALUES (:path, :description, :public, :date, :userid)");
        $r->execute([
            ':path' => 'None',
            ':description' => $description,
            ':public' => 1,
            ':date' => '2025-12-20',
            ':userid' => $_SESSION['user']
        ]);
        if (!$r) {
            addNotification('error', 'Erreur', 'Erreur lors de l\'ajout de l\'image');
            require 'templates/upload.php';
            return;
        }
        $id = $bd->lastInsertId();
        $path = '../images/';
        $path .= $id;
        $path .= '.'.$f_type;
        $r = $bd->prepare("UPDATE image SET path = :path WHERE id = :id");
        $r->execute([
            ':path' => $path,
            ':id' => $id
        ]);
        if (!$r) {
            addNotification('error', 'Erreur', 'Erreur lors de l\'ajout du chemin de l\'image');
            require 'templates/upload.php';
            return;
        }
        #deplacement de l'image
        if (!is_dir('../images')) {
            mkdir('images', 0755, true);
        }
        
        if (!move_uploaded_file($_FILES['fileInput']['tmp_name'], $path)) {
            addNotification('error', 'Erreur', 'Erreur lors de l\'ajout de l\'image');
            require 'templates/upload.php';
            return;
        }
        #liaison de l'image à ces tags &
        #Ajout de tout les tags à la bd
        foreach ($_POST['tags'] as $tag) {
            // Check if tag already exists
            $r = $bd->prepare("SELECT id FROM tag WHERE name = :name");
            $r->execute([':name' => $tag]);
            if (!$r) {
                addNotification('error', 'Erreur', 'Erreur lors de la vérification des tags');
                require 'templates/upload.php';
                return;
            }
            
            if ($r->rowCount() > 0) {
                // Tag exists, get its ID
                $tag_id = $r->fetch()['id'];
            } else {
                // Tag doesn't exist, create it
                $r = $bd->prepare("INSERT INTO tag (name) VALUES (:name)");
                $r->execute([':name' => $tag]);
                if (!$r) {
                    addNotification('error', 'Erreur', 'Erreur lors de l\'ajout des tags');
                    require 'templates/upload.php';
                    return;
                }
                $tag_id = $bd->lastInsertId();
            }
            $r = $bd->prepare("INSERT INTO taged (imageId, tagId) VALUES (:imageId, :tagId)");
            $r->execute([
                ':imageId' => $id,
                ':tagId' => $tag_id
            ]);
            if (!$r) {
                addNotification('error', 'Erreur', 'Erreur lors de l\'ajout des tags');
                require 'templates/upload.php';
                return;
            }
        }
        addNotification('success', 'Succès', 'L\'image à été ajouté');
        if (isset($_POST['callback'])) {
            header('Location: /' . $_POST['callback']);
        } else {
            header('Location: index.php');
        }
        exit();
    }
    require 'templates/upload.php';
}
?>
