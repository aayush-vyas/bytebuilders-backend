<?php

// src/Service/SpoonacularApiService.php
namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class SpoonacularApiService
{
    private $httpClient;
    private $apiKey;
    private $baseUrl;

    Const API_STATUS_SUCCESS =  "success";
    Const API_STATUS_ERROR =  "error";



    public function __construct(HttpClientInterface $httpClient, ContainerBagInterface $params)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $params->get('spoonacular_api_key');
        $this->baseUrl = $params->get('spoonacular_base_url');
    }

    private function request(string $endpoint, array $queryParams = []): array
    {
        $queryParams['apiKey'] = $this->apiKey;

        try {
            $response = $this->httpClient->request('GET', $this->baseUrl . $endpoint, [
                'query' => $queryParams,
            ]);

            return $response->toArray();
        } catch (\Exception $e) {
            // Handle or log the exception as needed
            return ['error' => $e->getMessage()];
        }
    }

    public function fetchAllRecipes(array $queryParams = []): array
    {
        return $this->request('recipes/complexSearch', $queryParams);
    }

    public function fetchRecipeDetails(int $id): array
    {
        return $this->request("recipes/{$id}/information", ['includeNutrition' => 'false']);
    }

    public function fetchRecipeInformation(int $id, array $additionalParams = []): array
    {
        return $this->request("recipes/{$id}/information", array_merge(['includeNutrition' => 'false'], $additionalParams));
    }

    public function fetchRecipeRecommendations(array $queryParams): array
    {
        return $this->request("recipes/complexSearch", $queryParams);
    }
}
