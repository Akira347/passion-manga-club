<?php

namespace Application\Controllers\Auth;

use \Application\Controllers\Homepage;
use \Application\Model\Auth\User;

class Login
{
    public function execute() {
        if (isset($_SESSION['user'])) {
            (new Homepage())->execute();
        } else {
            if (isset($_POST['identifiant']) && isset($_POST['password'])) {
                $identifiant = $_POST['identifiant'];
                $password = $_POST['password'];

                $user = new User($identifiant);
                $user->setPassword($password);
                $success = $user->login();
                
                // Si la connexion a été réalisée depuis une autre page que login, on souhaite rediriger l'utilisateur vers cette dernière, que la connexion soit un succès ou non
                if (isset($_POST['redirect_url']) && !empty($_POST['redirect_url'])) {
                    $redirect_url = $_POST['redirect_url'];
                    header('Location: '. $redirect_url);
                    exit;
                } else {
                    if ($success) {
                        require('templates/homepage.php');
                    } else {
                        require('templates/login.php');
                    }
                }
            } else {
                require('templates/login.php');
            }
        }
    }
}