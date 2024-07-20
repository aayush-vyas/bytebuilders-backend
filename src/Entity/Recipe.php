<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[ORM\Table(schema: 'reference_data')]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    private ?int $readyInMinutes = null;

    #[ORM\Column(nullable: true)]
    private ?int $servings = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    private ?int $calories = null;

    #[ORM\Column]
    private ?bool $vegetarian = null;

    #[ORM\Column]
    private ?bool $vegan = null;

    #[ORM\Column]
    private ?bool $glutenFree = null;

    #[ORM\Column]
    private ?bool $dairyFree = null;

    #[ORM\Column]
    private ?int $recipeId = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $cuisines = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $dishTypes = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $diets = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getReadyInMinutes(): ?int
    {
        return $this->readyInMinutes;
    }

    public function setReadyInMinutes(?int $readyInMinutes): static
    {
        $this->readyInMinutes = $readyInMinutes;

        return $this;
    }

    public function getServings(): ?int
    {
        return $this->servings;
    }

    public function setServings(?int $servings): static
    {
        $this->servings = $servings;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCalories(): ?int
    {
        return $this->calories;
    }

    public function setCalories(?int $calories): static
    {
        $this->calories = $calories;

        return $this;
    }

    public function isVegetarian(): ?bool
    {
        return $this->vegetarian;
    }

    public function setVegetarian(bool $vegetarian): static
    {
        $this->vegetarian = $vegetarian;

        return $this;
    }

    public function isVegan(): ?bool
    {
        return $this->vegan;
    }

    public function setVegan(bool $vegan): static
    {
        $this->vegan = $vegan;

        return $this;
    }

    public function isGlutenFree(): ?bool
    {
        return $this->glutenFree;
    }

    public function setGlutenFree(bool $glutenFree): static
    {
        $this->glutenFree = $glutenFree;

        return $this;
    }

    public function isDairyFree(): ?bool
    {
        return $this->dairyFree;
    }

    public function setDairyFree(bool $dairyFree): static
    {
        $this->dairyFree = $dairyFree;

        return $this;
    }

    public function getRecipeId(): ?int
    {
        return $this->recipeId;
    }

    public function setRecipeId(int $recipeId): static
    {
        $this->recipeId = $recipeId;

        return $this;
    }

    public function getCuisines(): array
    {
        return $this->cuisines;
    }

    public function setCuisines(array $cuisines): static
    {
        $this->cuisines = $cuisines;

        return $this;
    }

    public function getDishTypes(): array
    {
        return $this->dishTypes;
    }

    public function setDishTypes(array $dishTypes): static
    {
        $this->dishTypes = $dishTypes;

        return $this;
    }

    public function getDiets(): array
    {
        return $this->diets;
    }

    public function setDiets(array $diets): static
    {
        $this->diets = $diets;

        return $this;
    }
}
