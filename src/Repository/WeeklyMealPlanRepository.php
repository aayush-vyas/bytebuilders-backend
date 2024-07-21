<?php

namespace App\Repository;

use App\Entity\User;
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

    public function fetchUsersWeeklyPlan(Carbon $startDate, User $user): array
    {
        $startDate = new \DateTime($startDate);
        $endDate = clone $startDate;
        $endDate->modify('sunday this week');
        $id = $user->getId();
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT 
            plan_date, 
            jsonb_agg(json_build_object(time_slot, json_build_object(r.id, r.title, r.image, rm.ingredients))) AS meal_data
        FROM 
            reference_data.weekly_meal_plan wmp 
        JOIN 
        reference_data.recipe r ON r.id = wmp.recipe_id 
        JOIN 
        reference_data.recipe_meta rm ON rm.id = r.recipe_id 
        WHERE 
        user_id_id = :userId
        AND wmp.plan_date BETWEEN :startDate AND :endDate
        GROUP BY 
            plan_date
    ';
    
        $stmt = $connection->prepare($sql);
        $stmt->bindValue('userId', $id);
        $stmt->bindValue('startDate', $startDate->format('Y-m-d'));
        $stmt->bindValue('endDate', $endDate->format('Y-m-d'));
        return !empty($stmt->executeQuery()->fetchAllAssociative()) ? $stmt->executeQuery()->fetchAllAssociative()[0]:[];
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
