<?php

namespace App\Controller;

use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RecipeController extends AbstractController
{
    #[Route('/api/recipe', name: 'app_recipe', methods: 'GET')]
    public function getRecipes(EntityManagerInterface $em): JsonResponse
    {
        $recipes = $em->getRepository(Recipe::class)->findAll();

        return new JsonResponse($recipes);
    }

    #[Route('/api/recipe/recommend', name: 'app_recipe_recommend', methods: 'POST')]
    public function getRecipeRecommendations(Request $request, EntityManagerInterface $em, HttpClientInterface $client): JsonResponse
    {
        $data = json_decode($request->getContent());

        $apiKey = $this->getParameter('app.spoonacular_api_key');
        $apiUrl = $this->getParameter('app.spoonacular_api_url');

        $response = $client->request(
            'GET',
            "$apiUrl/recipes/complexSearch",
            [
                'headers' => [
                    'Content-Type'  => 'application/json',
                ],
                'query' => [
                    'apiKey' => $apiKey,
                    'cuisine' => $data->cuisine ?? '',
                    'diet' => $data->diet ?? '',
                    'includeIngredients' => $data->ingredients ?? '',
                    'type' => $data->type ?? ''
                ],
            ]
        );

        $responseData = null;
        if ($response->getStatusCode() == 200) {
            $responseContent = $response->getContent();
            $responseData = json_decode($responseContent, true);
        } else {
            // $this->logger->warning("Url shortner failed with code {$statusCode}: {$response->getContent(false)}");
        }

        return new JsonResponse($responseData);
    }
}
