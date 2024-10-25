<?php

namespace Application\Controllers\Manga;

use \Application\Controllers\Homepage;
use \Application\Model\Manga\Manga;
use \Application\Model\Manga\MangaApi;

class Search
{
    public function execute() {
        if (!isset($_POST['search']) || empty($_POST['search'])) {
            (new Homepage())->execute();
        } else {
            $search = $_POST['search'];

            $mangas = (new Manga)->getMangasByTitle($search);
            $mangasApi = (new MangaApi)->getMangasByTitle($search);
            
            require('templates/search.php');
        }
    }
}