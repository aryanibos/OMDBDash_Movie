<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Exception;

class OmdbService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl = 'http://www.omdbapi.com/';

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OMDB_API_KEY');
    }

    /**
     * Search for movies by title
     *
     * @param string $query
     * @param int $page
     * @return array
     */
    public function search($query, $page = 1, $type = null, $year = null)
    {
        $cacheKey = "search_{$query}_{$page}_{$type}_{$year}";

        // Cache for 60 minutes
        return Cache::remember($cacheKey, 60, function () use ($query, $page, $type, $year) {
            try {
                $params = [
                    'apikey' => $this->apiKey,
                    's' => $query,
                    'page' => $page,
                ];

                if ($type) $params['type'] = $type;
                if ($year) $params['y'] = $year;

                $response = $this->client->get($this->baseUrl, [
                    'query' => $params
                ]);

                return json_decode($response->getBody()->getContents(), true);
            } catch (Exception $e) {
                return ['Response' => 'False', 'Error' => $e->getMessage()];
            }
        });
    }

    /**
     * Get movie details by IMDB ID
     *
     * @param string $imdbId
     * @return array
     */
    public function getDetails($imdbId)
    {
        $cacheKey = "movie_{$imdbId}";

        // Cache for 60 minutes
        return Cache::remember($cacheKey, 60, function () use ($imdbId) {
            try {
                $response = $this->client->get($this->baseUrl, [
                    'query' => [
                        'apikey' => $this->apiKey,
                        'i' => $imdbId,
                        'plot' => 'full'
                    ]
                ]);

                return json_decode($response->getBody()->getContents(), true);
            } catch (Exception $e) {
                return ['Response' => 'False', 'Error' => $e->getMessage()];
            }
        });
    }
}
