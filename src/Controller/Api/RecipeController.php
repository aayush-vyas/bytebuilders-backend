<?php

// src/Controller/Api/AllRecipeController.php
namespace App\Controller\Api;

use App\Entity\Recipe;
use App\Services\RecipeService;
use App\Services\SpoonacularApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    public function __construct(private SpoonacularApiService $spoonacularApiService, private RecipeService $recipeService, private EntityManagerInterface $em)
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

    #[Route('/api/recipe/recommend', name: 'app_recipe_recommend', methods: 'GET')]
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

    #[Route('/api/recipe/{id}', name: 'app_recipe_single', methods: 'GET')]
    public function getRecipeById(Request $request): JsonResponse
    {
        $recipeId = $request->attributes->get('id');
        $queryParams = [];
        $searchParams = ['includeIngredients', 'excludeIngredients', 'diet', 'cuisine', 'type', 'query', 'intolerances'];
        foreach ($request->query->all() as $key => $value) {
            if (in_array($key, $searchParams)) {
                $queryParams[$key] = $value;
            }
        }

        $data = $this->spoonacularApiService->fetchRecipeInformation($recipeId, $queryParams);
        $data = $this->recipeService->singleRecipesWithFilteredDetails($data);

        return new JsonResponse($data);
    }
}
