<?php
    session_start();
    require_once(__DIR__ . '/config/mysql.php');
    require_once(__DIR__ . '/database_connect.php');
    require_once(__DIR__ . '/variables.php');
    require_once(__DIR__ . '/functions.php');

    $postData = $_POST;

    if (isset($postData['nickname']) && isset($postData['e-mail']) && isset($postData['password'])) {
        $nickname = $postData['nickname'];
        $email = $postData['e-mail'];
        $password = $postData['password'];

        // Vérification des données reçues une par une pour indiquer au visiteur des erreurs précises
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (trim($nickname) !== '') {
                if (trim($password) !== '') {
                    // Sécurisation contre les failles XSS et injections SQL
                    $nickname = htmlspecialchars($nickname);

                    // Vérification en bdd que l'e-mail n'est pas déjà utilisé
                    $query = $mysqlClient->prepare('SELECT COUNT(*) as email_exist FROM users WHERE email = :email');
                    $query->execute([
                        'email' => $email,
                    ]);
                    $result = $query->fetch();
                    
                    if ($result['email_exist'] > 0) {
                        $_SESSION['error'] = "Cet e-mail est déjà utilisé, veuillez vous connecter ou passer par Mot de passe oublié";
                        redirectToUrl('login.php');
                        exit;
                    }

                    /*
                        Vérification en bdd que le Pseudo n'est pas déjà utilisé (en réalité il faudrait faire cela en Javascript lors de la saisie du formulaire mais on n'en fera pas dans cette version)
                        À défaut de cela, on va sauvegarder les données saisies et indiquer une erreur de doublon du pseudonyme au visiteur
                    */
                    $query = $mysqlClient->prepare('SELECT COUNT(*) as nickname_exist FROM users WHERE nickname = :nickname');
                    $query->execute([
                        'nickname' => $nickname,
                    ]);
                    $result = $query->fetch();
                    
                    if ($result['nickname_exist'] > 0) {
                        $_SESSION['error_nickname_already_exist'] = "Ce pseudonyme est déjà utilisé, veuillez en saisir un autre";
                        $_SESSION['nickname_already_exist'] = true;
                        $_SESSION['nickname'] = $nickname;
                        $_SESSION['email'] = $email;
                        $_SESSION['password'] = $password;
                        redirectToUrl('register.php');
                        exit;
                    } 
                    
                    // Il n'y plus que le password à gérer, il faut le sécuriser avec password_hash qu'on pourra vérifier en lecture avec password_verify
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);

                    $register_date = date('Y-m-d');
                    $url_avatar = NULL;

                    // On enregistre le visiteur en bdd
                    $query = $mysqlClient->prepare('INSERT INTO users (nickname, email, password, register_date, url_avatar) VALUES(:nickname, :email, :password, :register_date, :url_avatar)');
                    $query->execute([
                        'nickname' => $nickname,
                        'email' => $email,
                        'password' => $password_hash,
                        'register_date' => $register_date,
                        'url_avatar' => $url_avatar,
                    ]);
                    $user_id = $mysqlClient->lastInsertId();

                    if ($user_id === false) {
                        $_SESSION['error'] = "Une erreur s'est produite";
                        redirectToUrl('register.php');
                        exit;
                    } else {
                        // On remplit nos données de session dont on pourrait avoir besoin dans la plupart des pages
                        $_SESSION['user']['id'] = $user_id;
                        $_SESSION['user']['nickname'] = $nickname;
                        $_SESSION['user']['email'] = $email;
                        $_SESSION['user']['register_date'] = $register_date;
                        $_SESSION['user']['url_avatar'] = $url_avatar;
                    }
                } else {
                    $_SESSION['error'] = "Le champ Mot de passe ne peut pas être vide ou rempli d'espaces";
                    redirectToUrl('register.php');
                    exit;
                }
            } else {
                $_SESSION['error'] = "Le champ Pseudo ne peut pas être vide ou rempli d'espaces";
                redirectToUrl('register.php');
                exit;
            }
        } else {
            $_SESSION['error'] = "L'e-mail renseigné n'est pas dans un format valide";
            redirectToUrl('register.php');
            exit;
        }
    } else {
        $_SESSION['error'] = "Les champs Pseudo, E-mail et Mot de passe doivent être renseignés";
        redirectToUrl('register.php');
        exit;
    }

?>