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
        $startDate = new \DateTime('now');
        $meals = $em->getRepository(WeeklyMealPlan::class)->fetchMealFrequencies($startDate);
        return new JsonResponse($meals);
    }
    

}
