<?php

declare(strict_types=1);

namespace Application\Model\Manga;

abstract class AbstractManga {
    protected string $title;
    protected string $title_en;
    protected string $poster_url;
    protected string $synopsis;
    protected string $release_date;
    
    abstract public function getMangaInfo(int $id): array;

    abstract public function getMangasByTitle(string $title): array;
}