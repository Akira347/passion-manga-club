<?php

namespace Application\Controllers\Manga;

use \Application\Model\Manga\Manga;
use \Application\Controllers\Manga\Mangas;
use \Application\Model\Review\Review;

class MangaSheet
{
    public function execute() {
        if (!isset($_GET['id'])) {
            (new Mangas())->execute();
        } else {
            $manga = (new Manga)->getMangaInfo($_GET['id']);
            $reviews = (new Review)->getMangaReviews($_GET['id']);
        }

        require('templates/manga.php');
    }
}