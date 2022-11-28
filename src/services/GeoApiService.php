<?php

namespace App\services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GeoApiService
{
    private string $geoApiUrl = "https://geo.api.gouv.fr";

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(
        private HttpClientInterface $httpClient
    )
    {
    }

    /**
     * @return string
     */
    public function test(): string
    {
        return "Hello";
    }

    /**
     * @return array|string
     */
    public function getAllRegions(): array
    {
        $response = $this->httpClient->request("GET", $this->geoApiUrl . "/regions");
        return $response->toArray();
    }

    /**
     * @param string $reg
     * @return array
     */
    public function getRegion(string $reg): array
    {
        $response = $this->httpClient->request("GET", $this->geoApiUrl . "/regions/" . $reg);
        return $response->toArray();
    }

    /**
     * @param string $reg ## region
     * @return array
     */
    public function getDepByReg(string $reg): array
    {
        $response = $this->httpClient->request("GET", $this->geoApiUrl . "/regions/" . $reg . "/departements");
        return $response->toArray();
    }

    /**
     * @param string $dep
     * @return array
     */
    public function getDepartement(string $dep): array
    {
        $response = $this->httpClient->request("GET", $this->geoApiUrl . "/departements/" . $dep);
        return $response->toArray();
    }

    /**
     * @param string $dep ## departement
     * @return array
     */
    public function getComByDep(string $dep): array
    {
        $response = $this->httpClient->request("GET", $this->geoApiUrl . "/departements/" . $dep . "/communes");
        return $response->toArray();
    }
}