<?php

namespace Application\Model\Auth;

use Application\Lib\DatabaseConnection;

class User {
    protected string $nickname;
    protected string $email;
    protected string $register_date;
    protected string $url_avatar;
    private string $password;
    private string $id;

    /*
        Surcharge de la fonction invoke car l'identifiant de l'User peut être un pseudo ou l'email
    */
    public function __construct(string $identifiant) {
        // On vérifie si on a un e-mail
        if (filter_var($identifiant, FILTER_VALIDATE_EMAIL)) {
            // On regarde si l'e-mail et le mdp correspondent en bdd
            $this->setEmail($identifiant);
        } else {
            // Sinon c'est un pseudo
            $this->setNickname($identifiant);
        }
    }

    public function getNickname(): string {
        return $this->nickname;
    }

    // Ici, on doit appeler le modèle pour vérifier que le pseudo n'existe pas déjà en bdd (unique) avant d'appliquer la modification
    public function setNickname(string $nickname) {
        if (trim($nickname) != '') {
            $this->nickname = htmlspecialchars($nickname);
        } else {
            throw new \Exception('Le pseudo ne peut pas être vide.');
        }
    }

    public function getEmail(): string {
        return $this->email;
    }

    // Ici, on doit appeler le modèle pour vérifier que l'email n'existe pas déjà en bdd avant d'appliquer la modification
    public function setEmail(string $email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $this->email = $email;
        } else {
            throw new \Exception('Cet e-mail n\'est pas valide.');
        }
    }

    public function getRegisterDate(): string {
        return $this->register_date;
    }

    public function getUrlAvatar(): string {
        return $this->url_avatar;
    }

    public function setUrlAvatar(string $url_avatar) {
        $this->url_avatar = $url_avatar;
    }

    public function getPassword(): string {
        return $this->password;
    }

    // Ici il faudra faire toutes les vérifications suivant la force attendue pour les mots de passe
    public function setPassword(string $password) {
        if (trim($password) != '') {
            $this->password = $password;
        } else {
            throw new \Exception('Le mot de passe ne peut pas être vide.');
        }
    }

    public function login(): bool {
        /*
            On exécute le code en fonction de la nature de l'identifiant
        */
        $database = new DatabaseConnection();
        $user = null;
        if (isset($this->email)) {
            $smtp = $database->getConnection()->prepare('SELECT * FROM users WHERE email = :email');
            $smtp->execute([
                'email' => $this->email,
            ]);
            $user = $smtp->fetch();
        } else {
            // C'est un pseudo ou un email invalide
            if (isset($this->nickname)) {
                $smtp = $database->getConnection()->prepare('SELECT * FROM users WHERE nickname = :nickname');
                $smtp->execute([
                    'nickname' => $this->nickname,
                ]);
                $user = $smtp->fetch();
            } else {
                $_SESSION['error'] = "Veuillez renseigner les champs 'E-mail ou Pseudo', et 'Mot de passe'";
                return false;
            }
        }
        
        if ($user > 0) {
            if (password_verify($this->password, $user['password'])) {
                $_SESSION['user'] = $user;
                return true;
            }
        }

        $_SESSION['error'] = "Erreur d'authentification, veuillez réessayer";
        return false;
    }

    static public function logout() {
        session_unset();
        session_destroy();
    }

    public function register(): bool {
        $database = new DatabaseConnection();

        // Vérification en bdd que l'e-mail n'est pas déjà utilisé
        $smtp = $database->getConnection()->prepare('SELECT COUNT(*) as email_exist FROM users WHERE email = :email');
        $smtp->execute([
            'email' => $this->email,
        ]);
        $result = $smtp->fetch();
        
        if ($result['email_exist'] > 0) {
            $_SESSION['error'] = "Cet e-mail est déjà utilisé, veuillez vous connecter ou passer par Mot de passe oublié";
            return false;
        }

        /*
            Vérification en bdd que le Pseudo n'est pas déjà utilisé
            (en réalité il faudrait faire cela en Javascript lors de la saisie du formulaire pour une question d'UX et de performance
            mais on n'en fera pas dans cette version)
            À défaut de cela, on va sauvegarder les données saisies et indiquer une erreur de doublon du pseudonyme au visiteur
        */
        $smtp = $database->getConnection()->prepare('SELECT COUNT(*) as nickname_exist FROM users WHERE nickname = :nickname');
        $smtp->execute([
            'nickname' => $this->nickname,
        ]);
        $result = $smtp->fetch();
        
        if ($result['nickname_exist'] > 0) {
            $_SESSION['error_nickname_already_exist'] = "Ce pseudonyme est déjà utilisé, veuillez en saisir un autre";
            $_SESSION['nickname_already_exist'] = true;
            $_SESSION['nickname'] = $this->nickname;
            $_SESSION['email'] = $this->email;
            $_SESSION['password'] = $this->password;
            
            return false;
        } 
        
        // Il n'y plus que le password à gérer, il faut le sécuriser avec password_hash qu'on pourra vérifier en lecture avec password_verify
        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
        $url_avatar = '';
        $register_date = date('Y-m-d');

        // On enregistre le visiteur en bdd
        $smtp = $database->getConnection()->prepare('INSERT INTO users (nickname, email, password, register_date, url_avatar) VALUES(:nickname, :email, :password, :register_date, :url_avatar)');
        $smtp->execute([
            'nickname' => $this->nickname,
            'email' => $this->email,
            'password' => $password_hash,
            'register_date'=> $register_date,
            'url_avatar' => $url_avatar,
        ]);
        $user_id = $database->getConnection()->lastInsertId();

        if ($user_id === false) {
            $_SESSION['error'] = "Une erreur s'est produite";

            return false;
        } else {
            $_SESSION['user']['id'] = $user_id;
            $_SESSION['user']['nickname'] = $this->nickname;
            $_SESSION['user']['email'] = $this->email;
            $_SESSION['user']['register_date'] = $register_date;
            $_SESSION['user']['url_avatar'] = $url_avatar;

            return true;
        }
    }
}