<?php

namespace App\Repository;

use App\Entity\WeeklyMealPlan;
use Carbon\Carbon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WeeklyMealPlan>
 */
class WeeklyMealPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeeklyMealPlan::class);
    }

    public function fetchMealFrequencies(\DateTime $startDate): array
{
    $endDate = (clone $startDate)->modify('+6 days');
    $meals = $this->createQueryBuilder('wmp')
        ->where('wmp.planDate BETWEEN :startDate AND :endDate')
        ->setParameter('startDate', $startDate)
        ->setParameter('endDate', $endDate)
        ->orderBy('wmp.planDate', 'ASC')
        ->getQuery()
        ->getResult();

    $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    $result = [];

    foreach ($meals as $meal) {
        $dayOfWeek = $daysOfWeek[$meal->getPlanDate()->format('w')];

        if (!isset($result[$dayOfWeek])) {
            $result[$dayOfWeek] = [
                'day' => $dayOfWeek,
                'mealId' => $meal->getId(),
                'breakfast' => [],
                'lunch' => [],
                'dinner' => [],
                'snacks' => []
            ];
        }

        $timeSlot = strtolower($meal->getTimeSlot());
        if (in_array($timeSlot, ['breakfast', 'lunch', 'dinner', 'snacks'])) {
            $recipe = $meal->getRecipe();
            // Add data for the corresponding time slot
            $result[$dayOfWeek][$timeSlot][] = [
                'recipe' => $recipe
            ];
        }
    }
        // Transform the result array to the desired format
        return array_values($result);
    }

    public function fetchUsersWeeklyPlan(Carbon $startDate): array
    {
        $endDate = $startDate->endOfWeek();

        $meals = $this->createQueryBuilder('wmp')
            ->select('json_agg()')
            ->where('wmp.user_id_id', $this->getUser()->getId())
            ->where('wmp.planDate BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->groupBy('wmp.planDate')
            ->orderBy('wmp.planDate', 'ASC')
            ->getQuery()
            ->getResult();
        dd($meals);
    } 
    
    //    /**
    //     * @return WeeklyMealPlan[] Returns an array of WeeklyMealPlan objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?WeeklyMealPlan
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
