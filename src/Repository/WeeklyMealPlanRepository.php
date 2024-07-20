<?php

namespace App\Repository;

use App\Entity\WeeklyMealPlan;
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

    public function fetchMealFrequencies(\DateTime $startDate):array
    {
        $endDate = (clone $startDate)->modify('+6 days');
        $meals = $this->createQueryBuilder('wmp')
            ->where('wmp.planDate BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->orderBy('wmp.planDate', 'ASC')
            ->getQuery()
            ->getResult();

        // Transform the result to only include necessary fields
        $data = array_map(function($meal) {
            return [
                'id' => $meal->getId(),
                'userId' => $meal->getUserId()->getId(),
                'planDate' => $meal->getPlanDate()->format('Y-m-d'),
                'timeSlot' => $meal->getTimeSlot(),
                'recipeId' => $meal->getRecipe()->getId(),
            ];
        }, $meals);

        return $data;
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
