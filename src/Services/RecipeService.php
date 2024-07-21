<?php

namespace App\Services;

class RecipeService
{

    public function __construct(private SpoonacularApiService $spoonacularApiService, private YoutubeApiService $youtubeApiService)
    {
    }

    public function fetchRecipeDetailsWithFilter($recipeId)
    {
        $recipeDetails = $this->spoonacularApiService->fetchRecipeDetails($recipeId);

        return $this->filterRecipeDetails($recipeDetails);
    }

    public function filterRecipeDetails($recipeDetails)
    {
        return [
            'id' => $recipeDetails['id'],
            'title' => $recipeDetails['title'],
            'readyInMinutes' => $recipeDetails['readyInMinutes'],
            'servings' => $recipeDetails['servings'],
            //TODO:  calories data
            //            'calories' => $recipeDetails['nutrition']['calories'],
            'image' => $recipeDetails['image'],
            'imageType' => $recipeDetails['imageType'],
            'cuisines' => $recipeDetails['cuisines'],
            'dishTypes' => $recipeDetails['dishTypes'],
            'vegetarian' => $recipeDetails['vegetarian'],
            'vegan' => $recipeDetails['vegan'],
            'glutenFree' => $recipeDetails['glutenFree'],
            'dairyFree' => $recipeDetails['dairyFree'],
            'veryHealthy' => $recipeDetails['veryHealthy'],
            'veryPopular' => $recipeDetails['veryPopular'],
            'sustainable' => $recipeDetails['sustainable'],
            'aggregateLikes' => $recipeDetails['aggregateLikes'],
            'healthScore' => $recipeDetails['healthScore'],
            'preparationMinutes' => $recipeDetails['preparationMinutes'],
            'cookingMinutes' => $recipeDetails['cookingMinutes'],
            'diets' => $recipeDetails['diets'],
            'occasions' => $recipeDetails['occasions'],
        ];
    }

    public function singleRecipesWithFilteredDetails($recipeDetails)
    {
        $youtubeLinks = $this->youtubeApiService->fetchVideoLinksFromQuery($recipeDetails['title']);

        return [
            'id' => $recipeDetails['id'],
            'title' => $recipeDetails['title'],
            'readyInMinutes' => $recipeDetails['readyInMinutes'],
            'servings' => $recipeDetails['servings'],
            //TODO:  calories data
            //            'calories' => $recipeDetails['nutrition']['calories'],
            'image' => $recipeDetails['image'],
            'imageType' => $recipeDetails['imageType'],
            'cuisines' => $recipeDetails['cuisines'],
            'dishTypes' => $recipeDetails['dishTypes'],
            'vegetarian' => $recipeDetails['vegetarian'],
            'vegan' => $recipeDetails['vegan'],
            'glutenFree' => $recipeDetails['glutenFree'],
            'dairyFree' => $recipeDetails['dairyFree'],
            'veryHealthy' => $recipeDetails['veryHealthy'],
            'veryPopular' => $recipeDetails['veryPopular'],
            'sustainable' => $recipeDetails['sustainable'],
            'aggregateLikes' => $recipeDetails['aggregateLikes'],
            'healthScore' => $recipeDetails['healthScore'],
            'preparationMinutes' => $recipeDetails['preparationMinutes'],
            'cookingMinutes' => $recipeDetails['cookingMinutes'],
            'diets' => $recipeDetails['diets'],
            'occasions' => $recipeDetails['occasions'],
            'analyzedInstructions' => $this->filteranalyzedInstructions($recipeDetails['analyzedInstructions']),
            'extendedIngredients' => $this->filterExtendedIngredients($recipeDetails['extendedIngredients']),
            'youtubeLink' => $youtubeLinks
        ];
    }

    private function filterExtendedIngredients($ingredients): array
    {
        return array_map(function ($ingredient) {
            return [
                'id' => $ingredient['id'],
                'original' => $ingredient['original']
            ];
        }, $ingredients);
    }

    private function filteranalyzedInstructions($analyzedInstructions)
    {
        if (empty($analyzedInstructions)) return null;
        foreach ($analyzedInstructions[0]['steps'] as $step) {
            $result[] = [
                "number" => $step["number"],
                "step" => $step["step"]
            ];
        }
        return $result;
    }
}
