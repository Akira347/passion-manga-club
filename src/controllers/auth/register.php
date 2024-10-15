<?php

namespace Application\Controllers\Auth\Register;

require_once('src/model/auth/user.php');
require_once('src/controllers/homepage.php');

use \Application\Controllers\Homepage\Homepage;
use \Application\Model\Auth\User\User;

class Register
{
    public function execute() {
        if (isset($_SESSION['user'])) {
            (new Homepage())->execute();
        } else {
            if (isset($_POST['e-mail']) && isset($_POST['nickname']) && isset($_POST['password'])) {
                $email = $_POST['e-mail'];
                $nickname = $_POST['nickname'];
                $password = $_POST['password'];

                $user = new User($email);
                $user->setEmail($email);
                $user->setNickname($nickname);
                $user->setPassword($password);

                $success = $user->register();
                
                if ($success) {
                    require('templates/homepage.php');
                } else {
                    require('templates/register.php');
                }
            } else {
                require('templates/register.php');
            }
        }
    }
}