<?php

declare(strict_types=1);

namespace Application\Model\Manga;

use Application\Model\Manga\AbstractManga;
use Application\Model\Manga\MangaApi;
use Application\Lib\DatabaseConnection;

class Manga extends AbstractManga {
    
    public function getMangaInfo(int $id): array {
        $database = new DatabaseConnection();

        $smtp = $database->getConnection()->prepare("SELECT * FROM mangas WHERE id = :id");
        $smtp->execute([
            'id' => $id,
        ]);
        $manga = $smtp->fetch();

        return $manga;
    }

    public function getMangasByTitle(string $title): array {
        $database = new DatabaseConnection();
        
        // Préparation de la condition LIKE autour du titre
        $likeTitle = "%". $title . "%";

        $smtp = $database->getConnection()->prepare("SELECT * FROM mangas WHERE (title LIKE :title) OR (title_en LIKE :title_en)");
        $smtp->execute([
            'title' => $likeTitle,
            'title_en' => $likeTitle,
        ]);
        $mangas = $smtp->fetchAll(\PDO::FETCH_ASSOC);

        return $mangas;
    }

    public function getListMangas(): array {
        $database = new DatabaseConnection();

        $smtp = $database->getConnection()->prepare("SELECT * FROM mangas ORDER BY id DESC");
        $smtp->execute();
        $mangas = $smtp->fetchAll(\PDO::FETCH_ASSOC);

        return $mangas;
    }

    public function isMangaApiExist(int $api_id): int {
        $database = new DatabaseConnection();

        // On doit d'abord vérifier qu'il n'existe pas en bdd, s'il existe on souhaite récupérer l'id du manga pour le site afin de rediriger l'utilisateur
        $smtp = $database->getConnection()->prepare("SELECT DISTINCT id FROM mangas WHERE api_id=:api_id");
        $smtp->execute([
            'api_id' => $api_id,
        ]);
        $mangaExist = $smtp->fetch();

        // On reçoit un id ou false si le manga n'existe pas en bdd
        if ($mangaExist) {
            return $mangaExist['id'];
        } else {
            return 0;
        }
    }

    public function addManga(array $manga, string $recommendMessage): int {
        $database = new DatabaseConnection();

        $mangaExist = $this->isMangaApiExist($manga['id']);
        
        if ($mangaExist > 0) {
            // Ici on pourrait proposer la redirection vers la fiche du manga sur le site
            // Aussi il ne faudrait pas afficher les mangas déjà présents sur le site lors de l'affichage des mangas de l'API via la recherche

            return $mangaExist;
        } else {
            // On transforme la date de sortie en format date Y-m-d pour l'insertion en bdd
            $release_date = sprintf('%04d-%02d-%02d', $manga['startDate']['year'], $manga['startDate']['month'], $manga['startDate']['day']);

            $smtp = $database->getConnection()->prepare("INSERT INTO mangas(api_id, title, title_en, poster_url, synopsis, release_date, rating, up_vote, down_vote) 
                                                        VALUES(:api_id, :title, :title_en, :poster_url, :synopsis, :release_date, :rating, 0, 0)");
            $smtp->bindValue('api_id', $manga['id']);
            $smtp->bindValue('title', $manga['title']['romaji']);
            $smtp->bindValue('title_en', $manga['title']['english']);
            $smtp->bindValue('poster_url', $manga['coverImage']['extraLarge']);
            $smtp->bindValue('synopsis', $manga['description']);
            $smtp->bindValue('release_date', $release_date);
            $smtp->bindValue('rating', $manga['averageScore']);
            $success = $smtp->execute();

            if ($success) {
                // On doit récupérer le nouvel id du manga ajouté pour pouvoir enregistrer la recommandation de l'utilisateur
                $manga_id = $database->getConnection()->lastInsertId();

                $smtp = $database->getConnection()->prepare("INSERT INTO reviews(user_id, manga_id, review, date) 
                                                    VALUES(:user_id, :manga_id, :review_message, NOW())");
                $smtp->execute([
                    'user_id' => $_SESSION['user']['id'],
                    'manga_id' => $manga_id,
                    'review_message' => $recommendMessage,
                ]);
                
                return (int) $manga_id;
            }
        }

        return $mangaExist;
    }

}