<?php

namespace App\Controller\Api;

use App\Entity\Recipe;
use App\Entity\WeeklyMealPlan;
use App\Enum\Recipe as EnumRecipe;
use Carbon\Carbon;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class MealPlannerController extends AbstractController
{
    #[Route('/api/meal/all', name: 'app_meal_planner')]
    public function getMealsByDate(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $startDateStr = $request->request->get('startDate');
        $startDate = new \DateTime($startDateStr);
        $meals = $em->getRepository(WeeklyMealPlan::class)->fetchMealFrequencies($startDate);
        return new JsonResponse($meals);
    }

    #[Route('/api/meal/create', name: 'create_meal-planner', methods: 'POST')]
    public function mealCreate(Request $request, EntityManagerInterface $em, SerializerInterface $serializerInterface): JsonResponse
    {
        $data = json_decode($request->getContent());
        $date = new DateTime($data->date);
        $user = $this->getUser();
        $recipe = $em->getRepository(Recipe::class)->findOneById($data->recipeId);
        $meal = new WeeklyMealPlan();
        $meal->setPlanDate($date);
        $meal->setRecipe($recipe);
        switch ($data->slot) {
            case EnumRecipe::BREAKFAST->value:
                $meal->setTimeSlot($data->slot);
                break;                
            case EnumRecipe::LUNCH->value:
                $meal->setTimeSlot($data->slot);
                break;
            case EnumRecipe::DINNER->value:
                $meal->setTimeSlot($data->slot);
                break;
            case EnumRecipe::SNACKS->value:
                $meal->setTimeSlot($data->slot);
                break;
            default:
                $meal->setTimeSlot('NA');
                break;
        }
        $meal->setUserId($user);

        $em->persist($meal);
        $em->flush();
        $newMeal = $em->getRepository(WeeklyMealPlan::class)->fetchUsersWeeklyPlan(Carbon::parse($date)->startOfWeek());
        
        return new JsonResponse(json_decode($serializerInterface->serialize($newMeal, 'json')));
    }

    #[Route('api/meal/delete/{id}', name: 'app_meal_delete', methods: ['GET'])]
    public function deleteMeal(int $id, EntityManagerInterface $em)
    {
        $id = $em->getRepository(WeeklyMealPlan::class)->findOneBy(array('id' => $id));

        if ($id != null){
            $em->remove($id);
            $em->flush();
           // Return success response
           return new JsonResponse(['message' => 'Meal deleted successfully'], JsonResponse::HTTP_OK);
        }

        // Return error response if meal not found
        return new JsonResponse(['message' => 'Meal not found'], JsonResponse::HTTP_NOT_FOUND);
    }

}
