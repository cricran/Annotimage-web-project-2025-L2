<?php

function home() {
    session_start();
    $bd = connect_db();
    $r = $bd->prepare("
    SELECT image.id, path, description, username as name, GROUP_CONCAT(name) as tags
    FROM image
    JOIN user ON user.id = image.userId
    LEFT JOIN taged ON taged.imageId = image.id 
    LEFT JOIN tag ON tag.id = taged.tagId
    WHERE public = 1 or image.userId = :id
    GROUP BY image.id, path, description, username
    ORDER BY date desc
    LIMIT 40
    ");
    $r->execute([
        'id' => $_SESSION['user'] ?? ''
    ]);
    $infos = $r->fetchAll();
    
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
        addNotification('success', 'Succès', 'Inscription réussie ! Vous pouvez vous connecter maintenant');

        if (isset($_POST['callback'])) {
            header('Location: /' . $_POST['callback']);
        } else {
            header('Location: /index.php');
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
            header('Location: /index.php');
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
        echo "delete";
        $bd = connect_db();

        $r_images = $bd->prepare("SELECT path FROM image WHERE userId = :id");
        $r_images->execute([':id' => $_SESSION['user']]);
        $images = $r_images->fetchAll();

        foreach ($images as $image) {
            $imagePath = __DIR__ . '/../images/' . $image['path'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $r_delete = $bd->prepare("DELETE FROM user WHERE id = :id");
        $r_delete->execute([':id' => $_SESSION['user']]);
        if (!$r_delete) {
            addNotification('error', 'Erreur', 'Erreur lors de la suppression du compte');
            require 'templates/settings.php';
            return;
        }

        $r_tag = $bd->prepare("
        DELETE FROM tag 
        WHERE id NOT IN (
            SELECT DISTINCT tagId 
            FROM taged
        )");
        $r_tag->execute();

        $_SESSION['user'] = null;
        addNotification('info', 'Information', 'Compte supprimé avec succès');
        header('Location: /index.php');
        return;
    }

    require 'templates/settings.php';
}

function upload() {
    session_start();
    if (!isset($_SESSION['user'])) {
        addNotification('error', 'Erreur', 'Vous devez être connecter pour ajouter une image');
        header('Location: /index.php');
        return;
    }
    if (isset($_POST['envoyer'])) {

        if(!isset($_POST['description']) || !isset($_POST['date'])) {
            addNotification('error', 'Erreur', 'Erreur lors de l\'ajout de l\'image 0');
            require 'templates/upload.php';
            return;
        }

        $issue = false;

        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
        $date = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');
        
        if (!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $date) || !strtotime($date)) {
            addNotification('error', 'Erreur', 'Format de date invalide (YYYY-MM-DD HH:MM:SS)');
            $issue = true;
        }
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
            } else {
                if (preg_match('#^[a-z]+/([a-z0-9\-\.\+]+)$#i', $_FILES['fileInput']['type'], $f_type)) {
                    $f_type =  $f_type[1];
                }
                
                if ($f_type !== 'png' && $f_type !== 'jpeg' && $f_type !== 'jpg' && $f_type !== 'webp') {
                    addNotification('error', 'Erreur', 'L\'image doit être aux format suivant : png, jpeg (jpeg) ou webp. Vous aves donné : ' . $f_type);
                    $issue = true;
                }
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
            ':public' => $_POST['public'] === null ? 0 : 1,
            ':date' => $date,
            ':userid' => $_SESSION['user']
        ]);
        if (!$r) {
            addNotification('error', 'Erreur', 'Erreur lors de l\'ajout de l\'image 1');
            require 'templates/upload.php';
            return;
        }
        $id = $bd->lastInsertId();
        $path = '../images/';
        $path .= $id;
        $path .= '.'.$f_type;
        $name = $id . '.'.$f_type;
        $r = $bd->prepare("UPDATE image SET path = :path WHERE id = :id");
        $r->execute([
            ':path' => $name,
            ':id' => $id
        ]);
        if (!$r) {
            addNotification('error', 'Erreur', 'Erreur lors de l\'ajout du chemin de l\'image 0.5');
            require 'templates/upload.php';
            return;
        }
        #deplacement de l'image
        if (!is_dir('../images')) {
            mkdir('images', 0755, true);
        }
        
        if (!move_uploaded_file($_FILES['fileInput']['tmp_name'], $path)) {
            addNotification('error', 'Erreur', 'Erreur lors de l\'ajout de l\'image 2');
            require 'templates/upload.php';
            return;
        }
        #liaison de l'image à ces tags &
        #Ajout de tout les tags à la bd
        foreach ($_POST['tags'] as $tag) {
            // tag exist ???
            $r = $bd->prepare("SELECT id FROM tag WHERE name = :name");
            $r->execute([':name' => $tag]);
            if (!$r) {
                addNotification('error', 'Erreur', 'Erreur lors de la vérification des tags');
                require 'templates/upload.php';
                return;
            }
            
            if ($r->rowCount() > 0) {
                $tag_id = $r->fetch()['id'];
            } else {
                // Tag dont exist
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

function tag() {
    session_start();
    $limit = 9;
    $page = isset($_GET['page']) && ctype_digit($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($page - 1) * $limit;
    $tag = isset($_GET['tag']) ? $_GET['tag'] : "";

    $attribut = "tag";

    $bd = connect_db();

    $getId = $bd->prepare("
    SELECT id 
    FROM tag 
    WHERE name = :tag
    ");
    $getId->execute(['tag' => $tag]);
    $tagId = $getId->fetch();
    if (!$tagId) {
        http_response_code(404);
        echo "Tag introuvable";
        exit;
    }
    $tagId = $tagId['id'];

    $sessionId = $_SESSION['user'] ?? null;

    $count = $bd->prepare("
    SELECT COUNT(DISTINCT image.id) as total
    FROM image
    JOIN taged ON taged.imageId = image.id
    WHERE taged.tagId = :tagId AND (public = 1 OR :sessionId = image.userId)
    ");
    $count->execute([
        'tagId' => $tagId,
        'sessionId' => $sessionId
    ]);
    $totalImages = $count->fetchAll()[0]['total'];
    $totalPages = max(1, ceil($totalImages / $limit));

    $r = $bd->prepare("
    SELECT image.id, path, description, username as name, GROUP_CONCAT(tag.name) as tags
    FROM image
    JOIN user ON user.id = image.userId
    LEFT JOIN taged ON taged.imageId = image.id 
    LEFT JOIN tag ON tag.id = taged.tagId
    WHERE (public = 1 OR :sessionId = image.userId)
    GROUP BY image.id, path, description, username
    HAVING :tagId IN (
        SELECT tagId 
        FROM taged 
        WHERE taged.imageId = image.id
    )
    ORDER BY MAX(date) DESC
    LIMIT $limit OFFSET $offset
    ");

    $r->execute([
        'tagId' => $tagId,
        'sessionId' => $sessionId
    ]);
    $infos = $r->fetchAll();

    $callback = '/index.php/tag?tag=' . urlencode($tag);
    
    require 'templates/tag.php';
}

function user() {
    session_start();
    $limit = 9;
    $page = isset($_GET['page']) && ctype_digit($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($page - 1) * $limit;
    $user = isset($_GET['user']) ? $_GET['user'] : "";

    $attribut = "user";

    $bd = connect_db();

    $getId = $bd->prepare("
    SELECT id 
    FROM user 
    WHERE username = :username
    ");
    $getId->execute(['username' => $user]);
    $userId = $getId->fetch();
    if (!$userId) {
        http_response_code(404);
        echo "Utilisateur introuvable";
        exit;
    }
    $userId = $userId['id'];

    $count = $bd->prepare("
    SELECT COUNT(DISTINCT image.id) as total
    FROM image
    WHERE image.userId = :userId AND (public = 1 OR :sessionId = :userId)
    ");
    $sessionId = $_SESSION['user'] ?? null;
    $count->execute([
        'userId' => $userId,
        'sessionId' => $sessionId
    ]);
    $totalImages = $count->fetchAll()[0]['total'];
    $totalPages = max(1, ceil($totalImages / $limit));

    $r = $bd->prepare("
    SELECT image.id, path, description, username as name, GROUP_CONCAT(tag.name) as tags
    FROM image
    JOIN user ON user.id = image.userId
    LEFT JOIN taged ON taged.imageId = image.id 
    LEFT JOIN tag ON tag.id = taged.tagId
    WHERE image.userId = :userId AND (public = 1 OR :sessionId = :userId)
    GROUP BY image.id, path, description, username
    ORDER BY MAX(date) DESC
    LIMIT $limit OFFSET $offset
    ");

    $r->execute([
        'userId' => $userId,
        'sessionId' => $_SESSION['user'] ?? '',
    ]);
    $infos = $r->fetchAll();

    $callback = '/index.php/user?user=' . $user;
    
    require 'templates/user.php';
}

function search() {
    session_start();
    $limit = 9;
    $page = isset($_GET['page']) && ctype_digit($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($page - 1) * $limit;
    $query = isset($_GET['q']) ? trim($_GET['q']) : "";

    $attribut = "q";
    $bd = connect_db();
    $sessionId = $_SESSION['user'] ?? null;

    if ($query === "") {
        $count = $bd->prepare("
        SELECT COUNT(*) as total
        FROM image
        WHERE public = 1 OR :sessionId = image.userId
        ");
        $count->execute(['sessionId' => $sessionId]);
        $totalImages = $count->fetch()['total'];
        $totalPages = max(1, ceil($totalImages / $limit));

        $r = $bd->prepare("
        SELECT image.id, path, description, username as name, GROUP_CONCAT(DISTINCT tag.name) as tags
        FROM image
        LEFT JOIN taged ON taged.imageId = image.id
        LEFT JOIN tag ON tag.id = taged.tagId
        LEFT JOIN user ON user.id = image.userId
        WHERE public = 1 OR image.userId = :sessionId
        GROUP BY image.id, path, description, username
        ORDER BY MAX(date) DESC
        LIMIT $limit OFFSET $offset
        ");
        $r->execute(['sessionId' => $sessionId]);
    } else {
        $terms = preg_split('/\s+/', $query);
        $users = [];
        $tags = [];
        $descs = [];

        foreach ($terms as $term) {
            if (str_starts_with($term, '@')) {
                $users[] = substr($term, 1);
            } elseif (str_starts_with($term, '#')) {
                $tags[] = substr($term, 1);
            } else {
                $descs[] = $term;
            }
        }

        $params = ['sessionId' => $sessionId];
        $conditions = [];

        if (!empty($users)) {
            $userConds = [];
            foreach ($users as $index => $user) {
                $param = "user$index";
                $userConds[] = "username = :$param";
                $params[$param] = $user;
            }
            $conditions[] = '(' . implode(' OR ', $userConds) . ')';
        }

        if (!empty($tags)) {
            $tagConds = [];
            foreach ($tags as $index => $tag) {
                $param = "tag$index";
                $tagConds[] = "t.name = :$param";
                $params[$param] = $tag;
            }
            $conditions[] = "(EXISTS (
                SELECT 1 FROM taged tg
                JOIN tag t ON t.id = tg.tagId
                WHERE tg.imageId = image.id AND (" . implode(" OR ", $tagConds) . ")
            ))";
        }

        if (!empty($descs)) {
            $descConds = [];
            foreach ($descs as $index => $desc) {
                $param = "desc$index";
                $descConds[] = "description LIKE :$param";
                $params[$param] = "%$desc%";
            }
            $conditions[] = "(" . implode(" OR ", $descConds) . ")";
        }

        $whereClause = empty($conditions) ? "1" : implode(" AND ", $conditions);

        $count = $bd->prepare("
        SELECT COUNT(DISTINCT image.id) as total
        FROM image
        LEFT JOIN taged ON taged.imageId = image.id
        LEFT JOIN tag ON tag.id = taged.tagId
        JOIN user ON user.id = image.userId
        WHERE ($whereClause)
          AND (public = 1 OR :sessionId = image.userId)
        ");
        $count->execute($params);
        $totalImages = $count->fetch()['total'];
        $totalPages = max(1, ceil($totalImages / $limit));

        $r = $bd->prepare("
        SELECT image.id, path, description, username as name, GROUP_CONCAT(DISTINCT tag.name) as tags
        FROM image
        JOIN user ON user.id = image.userId
        LEFT JOIN taged ON taged.imageId = image.id
        LEFT JOIN tag ON tag.id = taged.tagId
        WHERE ($whereClause)
          AND (public = 1 OR :sessionId = image.userId)
        GROUP BY image.id, path, description, username
        ORDER BY MAX(date) DESC
        LIMIT $limit OFFSET $offset
        ");
        $r->execute($params);
    }

    $infos = $r->fetchAll();
    $callback = '/index.php/search?q=' . urlencode($query);

    require 'templates/search.php';
}

function annotation() {
    session_start();
    if (!isset($_SESSION['user'])) {
        addNotification('error', 'Erreur', 'Vous devez être connecter pour accéder à cette page');
        header('Location: /index.php');
        return;
    } elseif (isset($_POST['annot'])) {
        if(!isset($_POST['id'])) {
            addNotification('error', 'Erreur', 'Erreur lors de l\'ajout des annotations');
            header('Location: /index.php/annotation');
            return;
        }

        $bd = connect_db();

        $r = $bd->prepare("
        SELECT *
        FROM image
        WHERE id = :id AND userId = :sessionId
        ");
        $r->execute([
            ':id' => $_POST['id'] ?? null, 
            ':sessionId' => $_SESSION['user']
        ]);
        if ($r->rowCount() != 1) {
            addNotification('error', 'Erreur', 'L\'image n\'existe pas ou vous n\'avez pas les droits pour la modifier');
            if (isset($_POST['callback'])) {
                header('Location: ' . $_POST['callback']);
            } else {
                header('Location: /index.php');
            }
            exit();
        }
        
        $r = $bd->prepare("DELETE FROM annotation WHERE imageId = :imageId");
        $r->execute([':imageId' => $_POST['id']]);

        foreach ($_POST['annot'] as $annot) {
            $json = json_decode($annot, true);
            $name = htmlspecialchars($json['name'], ENT_QUOTES, 'UTF-8');
            if (strlen($name) > 1024) {
                addNotification('error', 'Erreur', 'L\'annotation "'.$name.'" continet trop de carractères et n\'a pas put être ajouté. Cependant, toutes les annottations précédente à celle ci ont été ajouté.');
                header('Location: /index.php/annotation');
                return;
            }

            $r = $bd->prepare("
            INSERT INTO annotation (imageId, description, startX, startY, endX, endY) 
            VALUES (:imageId, :name, :sx, :sy, :ex, :ey)");
            $r->execute([
                ':imageId' => $_POST['id'],
                ':name' => $name,
                ':sx' => $json['start']['x'],
                ':sy' => $json['start']['y'],
                ':ex' => $json['end']['x'],
                ':ey' => $json['end']['y'],
            ]);
            if (!$r) {
                addNotification('error', 'Erreur', 'Erreur lors de l\'ajout de l\'annotations "'.$name.'". Cependant, toutes les annottations précédente à celle ci ont été ajouté.');
                header('Location: /index.php/annotation');
                return;
            }
        }
        addNotification('success', 'Succès', 'Les annotation ont été mise à jour');
        if (isset($_POST['callback'])) {
            header('Location: /' . $_POST['callback']);
        } else {
            header('Location: /index.php');
        }
        exit();
    } else {
        $bd = connect_db();
        $r = $bd->prepare("
        SELECT *
        FROM image
        WHERE id = :id AND userId = :sessionId
        ");
        $r->execute([
            ':id' => $_GET['id'] ?? null, 
            ':sessionId' => $_SESSION['user']
        ]);
        if ($r->rowCount() != 1) {
            addNotification('error', 'Erreur', 'L\'image n\'existe pas ou vous n\'avez pas les droits pour la modifier');
            if (isset($_POST['callback'])) {
                header('Location: ' . $_POST['callback']);
            } else {
                header('Location: /index.php');
            }
            exit();
        }
        $info = $r->fetch();
        $path = $info['path'];
        $id = $info['id'];
    
        require 'templates/annotation.php';
    }
}

function update() {
    session_start();
    if (!isset($_SESSION['user'])) {
        addNotification('error', 'Erreur', 'Vous devez être connecter pour accéder à cette page');
        header('Location: /index.php');
        return;
    } 
    
    if (isset($_POST['update'])) {
        if(!isset($_POST['id'])) {
            addNotification('error', 'Erreur', 'Erreur lors de la mise à jour de l\'image (id)');
            header('Location: /index.php');
            return;
        }

        $bd = connect_db();

        $r = $bd->prepare("
        SELECT *
        FROM image
        WHERE id = :id AND userId = :sessionId
        ");
        $r->execute([
            ':id' => $_POST['id'] ?? null, 
            ':sessionId' => $_SESSION['user']
        ]);
        if ($r->rowCount() != 1) {
            addNotification('error', 'Erreur', 'L\'image n\'existe pas ou vous n\'avez pas les droits pour la modifier');
            if (isset($_POST['callback'])) {
                header('Location: ' . $_POST['callback']);
            } else {
                header('Location: /index.php');
            }
            exit();
        }
        
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
        $date = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');
        $issue = false;
        if (!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $date) || !strtotime($date)) {
            addNotification('error', 'Erreur', 'Format de date invalide (YYYY-MM-DD HH:MM:SS)');
            $issue = true;
        }
        if (strlen($description) > 1024) {
            addNotification('error', 'Erreur', 'La description doit faire au plus 1024 caractères');
            $issue = true;
        }
        if (strlen($description) < 5) {
            addNotification('error', 'Erreur', 'La description doit faire au moins 5 caractères');
            $issue = true;
        }
        if ($issue) {
            if (isset($_POST['callback'])) {
                header('Location: /' . $_POST['callback']);
            } else {
                header('Location: /index.php');
            }
            return;
        }
        $r = $bd->prepare("
        UPDATE image 
        SET description = :description, date = :date, public = :public 
        WHERE id = :id"
        );
        $r->execute([
            ':description' => $description,
            ':date' => $date,
            ':public' => $_POST['public'] === null ? 0 : 1,
            ':id' => $_POST['id']
        ]);
        if (!$r) {
            addNotification('error', 'Erreur', 'Erreur lors de la mise à jour de l\'image');
            if (isset($_POST['callback'])) {
                header('Location: /' . $_POST['callback']);
            } else {
                header('Location: /index.php');
            }
            return;
        }
        $r = $bd->prepare("DELETE FROM taged WHERE imageId = :imageId");
        $r->execute([':imageId' => $_POST['id']]);
        if (!$r) {
            addNotification('error', 'Erreur', 'Erreur lors de la mise à jour des tags');
            if (isset($_POST['callback'])) {
                header('Location: /' . $_POST['callback']);
            } else {
                header('Location: /index.php');
            }
            return;
        }
        foreach ($_POST['tags'] as $tag) {
            if (strlen($tag) > 64) {
                addNotification('error', 'Erreur', 'Un tag doit faire au plus 64 caractères');
                if (isset($_POST['callback'])) {
                    header('Location: /' . $_POST['callback']);
                } else {
                    header('Location: /index.php');
                }
                return;
            }
            // tag exist ???
            $r = $bd->prepare("SELECT id FROM tag WHERE name = :name");
            $r->execute([':name' => $tag]);
            if (!$r) {
                addNotification('error', 'Erreur', 'Erreur lors de la vérification des tags');
                if (isset($_POST['callback'])) {
                    header('Location: /' . $_POST['callback']);
                } else {
                    header('Location: /index.php');
                }
                return;
            }
            
            if ($r->rowCount() > 0) {
                $tag_id = $r->fetch()['id'];
            } else {
                // Tag dont exist
                $r = $bd->prepare("INSERT INTO tag (name) VALUES (:name)");
                $r->execute([':name' => $tag]);
                if (!$r) {
                    addNotification('error', 'Erreur', 'Erreur lors de l\'ajout des tags');
                    if (isset($_POST['callback'])) {
                        header('Location: /' . $_POST['callback']);
                    } else {
                        header('Location: /index.php');
                    }
                    return;
                }
                $tag_id = $bd->lastInsertId();
            }
            $r = $bd->prepare("INSERT INTO taged (imageId, tagId) VALUES (:imageId, :tagId)");
            $r->execute([
                ':imageId' => $_POST['id'],
                ':tagId' => $tag_id
            ]);
            if (!$r) {
                addNotification('error', 'Erreur', 'Erreur lors de l\'ajout des tags');
                if (isset($_POST['callback'])) {
                    header('Location: /' . $_POST['callback']);
                } else {
                    header('Location: /index.php');
                }
                return;
            }
        }
        addNotification('success', 'Succès', 'L\'image à été mise à jour');
        if (isset($_POST['callback'])) {
            header('Location: /' . $_POST['callback']);
        } else {
            header('Location: index.php');
        }
        exit();
    }

    if (isset($_GET['id'])) {
        $bd = connect_db();
        $r = $bd->prepare("
        SELECT *
        FROM image
        WHERE id = :id AND userId = :sessionId
        ");
        $r->execute([
            ':id' => $_GET['id'] ?? null, 
            ':sessionId' => $_SESSION['user']
        ]);
        if ($r->rowCount() != 1) {
            addNotification('error', 'Erreur', 'L\'image n\'existe pas ou vous n\'avez pas les droits pour la modifier');
            if (isset($_POST['callback'])) {
                header('Location: ' . $_POST['callback']);
            } else {
                header('Location: /index.php');
            }
            exit();
        }
        $info = $r->fetch();
        $path = $info['path'];
        $description = $info['description'];
        $public = $info['public'];
        $id = $info['id'];
    
        require 'templates/update.php';
        return;
    }

    addNotification('error', 'Erreur', 'Aucune image spécifiée');
    if (isset($_POST['callback'])) {
        header('Location: /' . $_POST['callback']);
    } else {
        header('Location: /index.php');
    }
    return;

}

function image_delete () {
    session_start();
    include_once "../models.php";

    if (!isset($_SESSION['user'])) {
        addNotification('error', 'Erreur', 'Vous devez être connecté pour supprimer une image');
        if (isset($_POST['callback'])) {
            header('Location: /' . $_POST['callback']);
        } else {
            header('Location: /index.php');
        }
        exit();
    }

    if (!isset($_GET['id'])) {
        addNotification('error', 'Erreur', 'Aucune image spécifiée');
        if (isset($_POST['callback'])) {
            header('Location: /' . $_POST['callback']);
        } else {
            header('Location: /index.php');
        }
        exit();
    }

    $bd = connect_db();

    $r = $bd->prepare("
        SELECT path
        FROM image
        WHERE id = :id AND userId = :userId
    ");
    $r->execute([
        ':id' => $_GET['id'],
        ':userId' => $_SESSION['user']
    ]);
    if ($r->rowCount() !== 1) {
        addNotification('error', 'Erreur', 'Image introuvable ou accès refusé');
        if (isset($_POST['callback'])) {
            header('Location: /' . $_POST['callback']);
        } else {
            header('Location: /index.php');
        }
        exit();
    }

    $image = $r->fetch();
    $imagePath = __DIR__ . '/../images/' . $image['path'];

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    $r = $bd->prepare("DELETE FROM image WHERE id = :id AND userId = :userId");
    $success = $r->execute([
        ':id' => $_GET['id'],
        ':userId' => $_SESSION['user']
    ]);
    disconnect_db($bd);

    if ($success) {
        addNotification('success', 'Succès', 'Image supprimée avec succès');
    } else {
        addNotification('error', 'Erreur', 'Erreur lors de la suppression de l\'image');
    }

    if (isset($_POST['callback'])) {
        header('Location: /' . $_POST['callback']);
    } else {
        header('Location: /index.php');
    }
    return;
}