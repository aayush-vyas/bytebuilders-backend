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
use Symfony\Component\Serializer\SerializerInterface;

class RecipeController extends AbstractController
{
    public function __construct(
        private SpoonacularApiService $spoonacularApiService,
        private RecipeService $recipeService,
        private EntityManagerInterface $em,
        private SerializerInterface $serializer
    )
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
        $response = [];
        foreach ($data["results"] as $row){
            $response[] = $this->recipeService->fetchRecipeDetailsWithFilter($row["id"]);
        }

        return new JsonResponse($response);
    }

    #[Route('/api/recipe/recommend', name: 'app_recipe_recommend', methods: "GET")]
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
    public function getRecipeById(Request $request)
    {
        $recipeId = $request->attributes->get('id');
        // $data = json_decode('{"id":32579,"title":"Tuna Spaghetti With Fava Beans","readyInMinutes":20,"servings":2,"image":"https:\/\/img.spoonacular.com\/recipes\/32579-556x370.jpg","imageType":"jpg","cuisines":[],"dishTypes":["side dish","lunch","main course","main dish","dinner"],"vegetarian":false,"vegan":false,"glutenFree":false,"dairyFree":false,"veryHealthy":false,"veryPopular":false,"sustainable":false,"aggregateLikes":0,"healthScore":48,"preparationMinutes":null,"cookingMinutes":null,"diets":["pescatarian"],"occasions":[],"analyzedInstructions":[{"number":1,"step":"Fry the onion and add the garlic once the onion is translucent."},{"number":2,"step":"Add the tomatoes and the tomato puree"},{"number":3,"step":"Add the herbs and spices.Crush the stock cube and add to the sauce.Taste for seasoning and add the sugar.Cook on medium heat until sauce begins to thicken."},{"number":4,"step":"Add the tuna and broad beans.Cook on medium heat for as long as it takes you to boil the spaghetti, this way you\u0027re allowing the broad beans to absorb the flavours.Boil the spaghetti and add it to the sauce."},{"number":5,"step":"Add the chopped olives and on a very low heat incorporate the sauce into the pasta until every strand is well coated."},{"number":6,"step":"Serve with some Parmesan cheese and enjoy!"}],"extendedIngredients":[{"id":16054,"original":"1 cup canned broad beans"},{"id":10011693,"original":"1 can of plum tomatoes"},{"id":10115121,"original":"1 can tuna"},{"id":2031,"original":"1 pinch of cayenne pepper"},{"id":2042,"original":"1 pinch of dried thyme"},{"id":1034053,"original":"Extra virgin Olive oil"},{"id":1002011,"original":"2 crushed cloves of garlic"},{"id":1022027,"original":"1 pinch of dried Italian herbs"},{"id":9195,"original":"Some chopped olives"},{"id":11282,"original":"1 chopped onion"},{"id":2027,"original":"1 pinch of dried oregano"},{"id":1033,"original":"parmesan"},{"id":11420420,"original":"Spaghetti (amount is up to you-loads for me )"},{"id":19335,"original":"1 teaspoon of sugar"},{"id":1002028,"original":"1 pinch of sweet paprika"},{"id":11547,"original":"1 teaspoon tomato puree"},{"id":98845,"original":"1 vegetable stock cube"}],"youtubeLink":["https:\/\/www.youtube.com\/watch?v=PcykLKjibts","https:\/\/www.youtube.com\/watch?v=J32Sh5LfrwA","https:\/\/www.youtube.com\/watch?v=gFqDaRlWPjc","https:\/\/www.youtube.com\/watch?v=rfzUyz3HUxI","https:\/\/www.youtube.com\/watch?v=kZu9Lzxn6wY","https:\/\/www.youtube.com\/watch?v=O8MxWRVCLEc","https:\/\/www.youtube.com\/watch?v=MRwYto2sah4"]}', 1);
        // $queryParams = [];
        // $searchParams = ['includeIngredients', 'excludeIngredients', 'diet', 'cuisine', 'type', 'query', 'intolerances'];
        // foreach ($request->query->all() as $key => $value) {
        //     if (in_array($key, $searchParams)) {
        //         $queryParams[$key] = $value;
        //     }
        // }

        $data = $this->spoonacularApiService->fetchRecipeInformation($recipeId, []);
        $data = $this->recipeService->singleRecipesWithFilteredDetails($data);

        return new JsonResponse($data);
    }
}
