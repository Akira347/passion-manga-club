<?php

namespace Application\Controllers\Manga;

use \Application\Controllers\Homepage;
use \Application\Controllers\Manga\Mangas;
use \Application\Model\Manga\MangaApi;
use \Application\Model\Manga\Manga;
use \Application\Model\Review\Review;

class Recommend
{
    public function execute() {
        if (!isset($_GET['id'])) {
            (new Homepage())->execute();
        } else {
            $id = $_GET['id'];
            $manga = (new MangaApi)->getMangaInfo($id); // Soit on reçoit le manga de l'API, soit l'id du manga sur le site

            if (isset($manga['id_exist']) && $manga['id_exist'] > 0) {
                // On redirige l'utilisateur vers la page du manga sur le site
                $manga = (new Manga())->getMangaInfo($manga['id_exist']);
                require('templates/manga.php');
            } else {
                if (isset($_POST['recommendMessage']) && !empty($_POST['recommendMessage'])) {
                    // Une saisie utilisateur, on l'échappe pour éviter toute injection SQL
                    $recommendMessage = htmlspecialchars($_POST['recommendMessage']);

                    $mangaId = (new Manga)->addManga($manga, $recommendMessage);

                    if ($mangaId > 0) {
                        // On redirige l'utilisateur vers la page du manga sur le site
                        $manga = (new Manga())->getMangaInfo($mangaId);
                        $reviews = (new Review())->getMangaReviews($mangaId);
                        require('templates/manga.php');
                    } else {
                        require('templates/recommend.php');
                    }
                } else {
                    require('templates/recommend.php');
                }
            }
        }
    }
}