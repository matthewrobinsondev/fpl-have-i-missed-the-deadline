<?php

namespace App\ThirdParty\FPL;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Api implements ApiInterface
{
    private const BASE_URI = "https://fantasy.premierleague.com/api/";
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @return mixed[]
     */
    public function createRequest(string $endpoint): array
    {
        $cacheKey = 'api_' . $endpoint;

        return Cache::remember($cacheKey, 300, function () use ($endpoint) {
            try {
                $response = $this->client->request(
                    'GET',
                    self::BASE_URI . $endpoint,
                    [ 'Accept' => 'application/json']
                );

                return $response->getStatusCode() === 200 ? json_decode($response->getBody()->getContents(), true) : [];
            } catch (GuzzleException $e) {
                Log::warning($e->getMessage());
                return [];
            }
        });
    }
}
