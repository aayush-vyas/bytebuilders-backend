<?php

namespace App\Controller\Api;

use App\Entity\WeeklyMealPlan;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

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
