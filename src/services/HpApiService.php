<?php

namespace App\services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class HpApiService
{
    private string $hpApiUrl = "https://hp-api.herokuapp.com/api/characters";

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(
        private HttpClientInterface $httpClient
    )
    {
    }

    /**
     * @return array
     */
    public function getAllCharacters(): array
    {
        $response = $this->httpClient->request("GET", $this->hpApiUrl);
        return $response->toArray();
    }
}