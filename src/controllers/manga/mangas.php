<?php

namespace Application\Controllers\Manga;

use \Application\Model\Manga\Manga;

class Mangas
{
    public function execute() {
        $mangas = (new Manga)->getListMangas();

        require('templates/mangas.php');
    }
}