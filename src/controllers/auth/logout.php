<?php

namespace Application\Controllers\Auth;

use \Application\Controllers\Homepage;
use \Application\Model\Auth\User;

class Logout
{
    public function execute() {
        if (isset($_SESSION['user'])) {
            User::logout();
        }
        (new Homepage())->execute();
    }
}