<?php
    require_once(__DIR__ . '/config/mysql.php');
    require_once(__DIR__ . '/database_connect.php');
    require_once(__DIR__ . '/variables.php');
    require_once(__DIR__ . '/functions.php');

    $postData = $_POST;

    /*
        En identifiant on reçoit un e-mail OU un pseudo, on doit donc vérifier ce qui nous a été envoyé
        pour pouvoir faire la bonne comparaison en bdd
    */
    if (isset($postData['identifiant']) && isset($postData['password'])) {
        $identifiant = $postData['identifiant'];
        $password = $postData['password'];

        // On vérifie si on a un e-mail
        if (filter_var($identifiant, FILTER_VALIDATE_EMAIL)) {
            // On regarde si l'e-mail et le mdp correspondent en bdd
            $email = $identifiant;
            $query = $mysqlClient->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
            $query->execute([
                'email' => $email,
                'password' => $password,
            ]);
            $user = $query->fetch();
        } else {
            // Ce n'est pas un e-mail ou alors il est invalide
            // On lance donc la vérification du pseudo et s'il existe ou non en bdd et s'il correspond au mdp saisi
            if (!empty(trim($identifiant)) && !empty(trim($password))) {
                // Ici, on a une saisie utilisateur de type "texte" on va donc se prémunir de failles XSS et d'injection SQL
                $nickname = htmlspecialchars($identifiant);
                
                $query = $mysqlClient->prepare('SELECT * FROM users WHERE nickname = :nickname AND password = :password');
                $query->execute([
                    'nickname' => $nickname,
                    'password' => $password,
                ]);
                $user = $query->fetch();
            }
            
            if (!empty($user)) {
                session_start();
                $_SESSION['user']['nickname'] = $user['nickname'];
                $_SESSION['user']['register_date'] = $user['register_date'];
                $_SESSION['user']['email'] = $user['email'];
                $_SESSION['user']['avatar'] = $user['avatar'];
                redirectToUrl('index.php');
            } else {
                echo "Erreur d'authentification";
                redirectToUrl('login.php');
            }
        }
    } else {
        echo "Veuillez renseigner les champs 'E-mail ou Pseudo', et 'Mot de passe'";
        redirectToUrl('login.php');
    }
?>