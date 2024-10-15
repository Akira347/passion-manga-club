<?php
session_start();
require_once('src/controllers/auth/login.php');
require_once('src/controllers/auth/logout.php');
require_once('src/controllers/auth/register.php');
require_once('src/controllers/homepage.php');

use Application\Controllers\Homepage\Homepage;
use Application\Controllers\Auth\Login\Login;
use Application\Controllers\Auth\Logout\Logout;
use Application\Controllers\Auth\Register\Register;

try {
    /*
        A l'avenir : réécriture URLs via la configuration Apache et réception de l'action directement via $_SERVER['REQUEST_URI']
        Pour l'instant, boucle if pour récupérer l'action et utiliser un switch en anticipation des nombreuses pages du projet
    */
    $action = 'homepage';

    if (isset($_GET['action']) && $_GET['action'] !== '') {
        $action = $_GET['action'];
    }

    switch ($action) {
        case 'homepage' : (new Homepage())->execute();
            break;
        case 'login': (new Login())->execute();
            break;
        case 'register': (new Register())->execute();
            break;
        case 'logout': (new Logout())->execute();
            break;
        default: (new Homepage())->execute(); 
    }

} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    require('templates/error.php');
}