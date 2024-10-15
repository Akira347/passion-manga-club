<?php

namespace Application\Controllers\Auth\Login;

require_once('src/model/auth/user.php');
require_once('src/controllers/homepage.php');

use \Application\Controllers\Homepage\Homepage;
use \Application\Model\Auth\User\User;

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
                
                if ($success) {
                    require('templates/homepage.php');
                } else {
                    require('templates/login.php');
                }
            } else {
                require('templates/login.php');
            }
        }
    }
}