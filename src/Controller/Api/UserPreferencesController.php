<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Diet;
use App\Entity\Allergies;
use App\Entity\Cuisine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;

class UserPreferencesController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/api/user/preferences/add', name: 'api_user_preferences_add', methods: ['POST'])]
    public function addPreferences(Request $request): JsonResponse
    {
        $user = $this->security->getUser();
        if (!$user) {
            $user = $this->entityManager->getRepository(User::class)->findOneById(2);
//            return new JsonResponse(['error' => 'User not authenticated'], 401);
        }
        $data = json_decode($request->getContent(), true);

        $diets = $data['diet'] ?? [];
        $allergies = $data['allergies'] ?? [];
        $cuisines = $data['cuisines'] ?? [];

        // Clear existing preferences
        $user->getDiets()->clear();
        $user->getAllergies()->clear();
        $user->getCuisine()->clear();

        // Add new diets
        foreach ($diets as $dietId) {
            $diet = $this->entityManager->getRepository(Diet::class)->findOneBy(['id' => $dietId]);
            if ($diet) {
                $user->getDiets()->add($diet);
            }
        }

        // Add new allergies
        foreach ($allergies as $allergyId) {
            $allergy = $this->entityManager->getRepository(Allergies::class)->findOneBy(['id' => $allergyId]);
            if ($allergy) {
                $user->getAllergies()->add($allergy);
            }
        }

        // Add new cuisines
        foreach ($cuisines as $cuisineId) {
            $cuisine = $this->entityManager->getRepository(Cuisine::class)->findOneBy(['id' => $cuisineId]);
            if ($cuisine) {
                $user->getCuisine()->add($cuisine);
            }
        }

        // Save changes
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Preferences added successfully']);
    }

    #[Route('/api/user/preferences', name: 'api_user_preferences_get', methods: ['GET'])]
    public function getPreferences(TokenStorageInterface $tokenStorage): JsonResponse
    {

        $token = $tokenStorage->getToken();

        $user = $token->getUser();

//        $user = $this->security->getUser();
        if (!$user) {
//            $user = $this->entityManager->getRepository(User::class)->findOneById(2);
            return new JsonResponse(['error' => 'User not authenticated'], 401);
        }

        $diets = array_map(function ($diet) {
            return $diet->getTitle();
        }, $user->getDiets()->toArray());

        $allergies = array_map(function ($allergy) {
            return $allergy->getTitle();
        }, $user->getAllergies()->toArray());

        $cuisines = array_map(function ($cuisine) {
            return $cuisine->getTitle();
        }, $user->getCuisine()->toArray());

        return new JsonResponse([
            'diet' => $diets,
            'allergies' => $allergies,
            'cuisins' => $cuisines
        ]);
    }

    #[Route('/api/user/preferences/edit', name: 'api_user_preferences_edit', methods: ['PUT'])]
    public function editPreferences(Request $request): JsonResponse
    {
        $user = $this->security->getUser();
        if (!$user) {
            $user = $this->entityManager->getRepository(User::class)->findOneById(2);
//            return new JsonResponse(['error' => 'User not authenticated'], 401);
        }

        $data = json_decode($request->getContent(), true);

        $diets = $data['diet'] ?? [];
        $allergies = $data['allergies'] ?? [];
        $cuisines = $data['cuisines'] ?? [];

        // Update diets
        foreach ($diets as $dietId) {
            $diet = $this->entityManager->getRepository(Diet::class)->find($dietId);
            if ($diet) {
                if (!$user->getDiets()->contains($diet)) {
                    $user->getDiets()->add($diet);
                }
            }
        }

        // Remove diets no longer in the request
        foreach ($user->getDiets() as $existingDiet) {
            if (!in_array($existingDiet->getId(), $diets)) {
                $user->getDiets()->removeElement($existingDiet);
            }
        }

        // Update allergies
        foreach ($allergies as $allergyId) {
            $allergy = $this->entityManager->getRepository(Allergies::class)->find($allergyId);
            if ($allergy) {
                if (!$user->getAllergies()->contains($allergy)) {
                    $user->getAllergies()->add($allergy);
                }
            }
        }

        // Remove allergies no longer in the request
        foreach ($user->getAllergies() as $existingAllergy) {
            if (!in_array($existingAllergy->getId(), $allergies)) {
                $user->getAllergies()->removeElement($existingAllergy);
            }
        }

        // Update cuisines
        foreach ($cuisines as $cuisineId) {
            $cuisine = $this->entityManager->getRepository(Cuisine::class)->find($cuisineId);
            if ($cuisine) {
                if (!$user->getCuisine()->contains($cuisine)) {
                    $user->getCuisine()->add($cuisine);
                }
            }
        }

        // Remove cuisines no longer in the request
        foreach ($user->getCuisine() as $existingCuisine) {
            if (!in_array($existingCuisine->getId(), $cuisines)) {
                $user->getCuisine()->removeElement($existingCuisine);
            }
        }

        // Save changes
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Preferences updated successfully']);
    }


    #[Route('/api/user/preferences/list', name: 'api_user_preferences_get_list', methods: ['GET'])]
    public function getPreferencesData(): JsonResponse
    {
        // Fetch all records from the Diet, Allergies, and Cuisine tables
        $dietRepository = $this->entityManager->getRepository(Diet::class);
        $allergyRepository = $this->entityManager->getRepository(Allergies::class);
        $cuisineRepository = $this->entityManager->getRepository(Cuisine::class);

        $diets = $dietRepository->findAll();
        $allergies = $allergyRepository->findAll();
        $cuisines = $cuisineRepository->findAll();

        // Prepare the response data
        $dietData = [];
        foreach ($diets as $diet) {
            $dietData[$diet->getId()] = $diet->getTitle();
        }

        $allergyData = [];
        foreach ($allergies as $allergy) {
            $allergyData[$allergy->getId()] = $allergy->getTitle();
        }

        $cuisineData = [];
        foreach ($cuisines as $cuisine) {
            $cuisineData[$cuisine->getId()] = $cuisine->getTitle();
        }

        return new JsonResponse([
            'diet' => $dietData,
            'allergies' => $allergyData,
            'cuisines' => $cuisineData
        ]);
    }
}
