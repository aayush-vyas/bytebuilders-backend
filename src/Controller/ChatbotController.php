<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChatbotController extends AbstractController
{
    private $apiKey;
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient, ParameterBagInterface $parameterBag)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $parameterBag->get('openai_api_key'); // Fetch the API key from parameters
    }

    #[Route('/api/chat', name: 'api_chat')]
    public function generateContent(Request $request): Response
    {

        $data = json_decode($request->getContent(), true);
        $prompt = $data['messageHistory'];

        $url = 'https://api.openai.com/v1/chat/completions';
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ];
        $body = json_encode([
            "model" => "gpt-3.5-turbo",
            "messages" => $prompt
        ]);

        $response = $this->httpClient->request('POST', $url, [
            'headers' => $headers,
            'body' => $body,
        ]);

        $content = $response->getContent();
        $decodedResponse = json_decode($content, true);
        $messageContent = $decodedResponse['choices'][0]['message']['content'] ?? '';

        return new JsonResponse($messageContent);
    }
}
