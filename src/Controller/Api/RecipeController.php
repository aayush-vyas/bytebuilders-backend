<?php

// src/Controller/Api/AllRecipeController.php
namespace App\Controller\Api;

use App\Services\RecipeService;
use App\Services\SpoonacularApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    public function __construct(private SpoonacularApiService $spoonacularApiService, private RecipeService $recipeService)
    {
    }

    #[Route('/api/recipe/all', name: 'api_all_recipes', methods: ['GET'])]
    public function getAllRecipes(Request $request): JsonResponse
    {
        $queryParams = [];
        foreach ($request->query->all() as $key => $value) {
            if (in_array($key, ['diet', 'cuisine', 'type', 'query', 'number', 'offset', 'intolerances'])) {
                $queryParams[$key] = $value;
            }
        }

        $data = $this->spoonacularApiService->fetchAllRecipes($queryParams);
        $data = $this->recipeService->fetchRecipesWithFilteredDetails($data);

        return new JsonResponse($data);
    }

    #[Route('/api/recipe/recommend', name: 'app_recipe_recommend', methods: 'POST')]
    public function getRecipeRecommendations(Request $request): JsonResponse
    {
        $queryParams = [];
        $searchParams = ['includeIngredients', 'excludeIngredients', 'diet', 'cuisine', 'type', 'query', 'intolerances'];
        foreach ($request->query->all() as $key => $value) {
            if (in_array($key, $searchParams)) {
                $queryParams[$key] = $value;
            }
        }

        $data = $this->spoonacularApiService->fetchRecipeRecommendations($queryParams);

        return new JsonResponse($data);
    }
}
