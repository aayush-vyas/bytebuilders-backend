<?php

namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class YoutubeApiService
{

    private $httpClient;
    private $apiKey;
    private $baseUrl;

    public function __construct(HttpClientInterface $httpClient, ContainerBagInterface $params)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $params->get('youtube_api_key');
        $this->baseUrl = $params->get('youtube_base_url');
    }

    private function request(string $endpoint, string $query = ''): array
    {
        $queryParams = [
            'part' => 'snippet',
            'q' => "how to make " . $query . " in hindi",
            'type' => 'video',
            'maxResults' => 7,
            'key' => $this->apiKey,
            'order' => 'relevance'
        ];

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

    public function fetchVideoLinksFromQuery(string $query)
    {
        $response = $this->request("search", $query);

        $ytLinks = [];
        foreach($response['items'] as $item) {
            $ytLinks[] = "https://www.youtube.com/watch?v=" . $item["id"]["videoId"];
        }

        return $ytLinks;
    }
}
