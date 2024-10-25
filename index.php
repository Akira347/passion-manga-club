<?php
session_start();

spl_autoload_register(function ($class) {
    $prefix = 'Application\\';
    $base_dir = __DIR__ . '/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

require 'vendor/autoload.php';

use Application\Controllers\Homepage;
use Application\Controllers\Auth\Login;
use Application\Controllers\Auth\Logout;
use Application\Controllers\Auth\Register;
use Application\Controllers\Manga\Recommend;
use Application\Controllers\Manga\Search;
use Application\Controllers\Manga\Mangas;
use Application\Controllers\Manga\MangaSheet;

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
        case 'recommend': (new Recommend())->execute();
            break;
        case 'search': (new Search())->execute();
            break;
        case 'mangas': (new Mangas())->execute();
            break;
        case 'manga': (new MangaSheet())->execute();
            break;
        default: (new Homepage())->execute(); 
    }

} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    require('templates/error.php');
}