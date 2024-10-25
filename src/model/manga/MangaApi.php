<?php

declare(strict_types=1);

namespace Application\Model\Manga;

use Application\Model\Manga\AbstractManga;
use Application\Model\Manga\Manga;

class MangaApi extends AbstractManga {

    public function getMangaInfo(int $id): array {
        // On doit d'abord vérifier si le manga n'est pas déjà recommandé sur le site, dans ce cas on devra rediriger le visiteur vers la page du manga sur le site
        $mangaId = (new Manga())->isMangaApiExist($id);

        if ($mangaId > 0) {
            $manga['id_exist'] = $mangaId;
            return $manga;
        } else {
            $query = '
            query ($id: Int) {
                    Page {
                            media(id: $id) {
                                    id
                                    title {
                                            romaji
                                            english
                                    }
                                    coverImage {
                                        extraLarge
                                    }
                                    startDate {
                                        day
                                        month
                                        year
                                    }
                                    status
                                    genres
                                    description
                                    averageScore
                            }
                    }
            }
            ';

            $variables = [
                "id" => $id,
            ];

            $http = new \GuzzleHttp\Client;
            $response = $http->post('https://graphql.anilist.co', [
                'json' => [
                    'query' => $query,
                    'variables' => $variables,
                ]
            ]);
            $body = $response->getBody()->getContents();

            $body = json_decode($body, true);

            $manga = $body['data']['Page']['media'][0];

            return $manga;
        }
    }

    public function getMangasByTitle(string $title): array {
        $query = '
        query ($search: String!) {
            Page {
                media(search: $search, type: MANGA) {
                    id
                    title {
                        romaji
                        english
                    }
                    coverImage {
                        extraLarge
                    }
                }
            }
        }
        ';

        $variables = [
            "search" => $title
        ];

        $http = new \GuzzleHttp\Client;
        $response = $http->post('https://graphql.anilist.co', [
            'json' => [
                'query' => $query,
                'variables' => $variables,
            ]
        ]);
        $body = $response->getBody()->getContents();

        $body = json_decode($body, true);

        $mangas = $body['data']['Page']['media'];

        return $mangas;
    }

}