<?php

namespace App\Services;

class RecipeService
{

    public function __construct(private  SpoonacularApiService $spoonacularApiService)
    {
    }

    public function fetchRecipeDetailsWithFilter($recipeId)
    {
        $recipeDetails = $this->spoonacularApiService->fetchRecipeDetails($recipeId);

        return $this->filterRecipeDetails($recipeDetails);
    }

    private function filterRecipeDetails($recipeDetails)
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
    public function fetchRecipesWithFilteredDetails($data)
    {
        foreach ($data['results'] as &$recipe) {
            $recipeDetails = $this->fetchRecipeDetailsWithFilter($recipe['id']);
            $recipe['details'] = $recipeDetails;
        }
        return $data;
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
