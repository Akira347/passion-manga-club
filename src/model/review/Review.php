<?php

declare(strict_types=1);

namespace Application\Model\Review;

use Application\Lib\DatabaseConnection;

class Review {
    private int $user_id;
    private int $manga_id;
    private string $review;
    private string $date;

    public function getMangaReviews(int $mangaId): array {
        $database = new DatabaseConnection();

        $smtp = $database->getConnection()->prepare("SELECT r.review, r.date, u.nickname
                                                    FROM reviews as r
                                                    JOIN users as u
                                                    ON u.id=r.user_id
                                                    WHERE r.manga_id = :id
                                                    ORDER BY r.date DESC");
        $smtp->execute([
            'id' => $mangaId,
        ]);
        $reviews = $smtp->fetchAll(\PDO::FETCH_ASSOC);

        return $reviews;
    }
}