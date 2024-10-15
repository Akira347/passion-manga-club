<?php

namespace Application\Controllers\Auth\Logout;

require_once('src/model/auth/user.php');
require_once('src/controllers/homepage.php');

use \Application\Controllers\Homepage\Homepage;
use \Application\Model\Auth\User\User;

class Logout
{
    public function execute() {
        if (isset($_SESSION['user'])) {
            User::logout();
        }
        (new Homepage())->execute();
    }
}