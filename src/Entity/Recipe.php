<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[ORM\Table(schema: 'reference_data')]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("recipe:read")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("recipe:read")]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    #[Groups("recipe:read")]
    private ?int $readyInMinutes = null;

    #[ORM\Column(nullable: true)]
    #[Groups("recipe:read")]
    private ?int $servings = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("recipe:read")]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    #[Groups("recipe:read")]
    private ?int $calories = null;

    #[ORM\Column]
    #[Groups("recipe:read")]
    private ?bool $vegetarian = null;

    #[ORM\Column]
    #[Groups("recipe:read")]
    private ?bool $vegan = null;

    #[ORM\Column]
    #[Groups("recipe:read")]
    private ?bool $glutenFree = null;

    #[ORM\Column]
    #[Groups("recipe:read")]
    private ?bool $dairyFree = null;

    #[ORM\Column]
    #[Groups("recipe:read")]
    private ?int $recipeId = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups("recipe:read")]
    private string $cuisines = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups("recipe:read")]
    private string $dishTypes = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups("recipe:read")]
    private string $diets = '';

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

    public function getCuisines(): string
    {
        return $this->cuisines;
    }

    public function setCuisines(string $cuisines): static
    {
        $this->cuisines = $cuisines;

        return $this;
    }

    public function getDishTypes(): string
    {
        return $this->dishTypes;
    }

    public function setDishTypes(string $dishTypes): static
    {
        $this->dishTypes = $dishTypes;

        return $this;
    }

    public function getDiets(): string
    {
        return $this->diets;
    }

    public function setDiets(string $diets): static
    {
        $this->diets = $diets;

        return $this;
    }
}
