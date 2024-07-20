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
    private $spoonacularApiService;

    public function __construct(SpoonacularApiService $spoonacularApiService, private RecipeService $recipeService)
    {
        $this->spoonacularApiService = $spoonacularApiService;
    }

    #[Route('/api/recipe/all', name: 'api_all_recipes', methods: ['GET'])]
    public function getAllRecipes(Request $request): JsonResponse
    {
        $queryParams = [];
        foreach ($request->query->all() as $key => $value) {
            if (in_array($key, ['diet', 'cuisine', 'type', 'query', 'number', 'offset'])) {
                $queryParams[$key] = $value;
            }
        }

        $data = $this->spoonacularApiService->fetchAllRecipes($queryParams);
        $data = $this->recipeService->fetchRecipesWithFilteredDetails($data);

        return new JsonResponse($data);
    }
}
