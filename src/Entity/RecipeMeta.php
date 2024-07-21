<?php

namespace App\Entity;

use App\Repository\RecipeMetaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RecipeMetaRepository::class)]
#[ORM\Table(schema: 'reference_data')]
class RecipeMeta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups("recipe:read")]
    private ?string $instructions = null;

    #[ORM\Column]
    #[Groups("recipe:read")]
    private array $analysedInstructions = [];

    #[ORM\Column]
    #[Groups("recipe:read")]
    private ?int $healthScore = null;

    #[ORM\Column]
    #[Groups("recipe:read")]
    private array $ingredients = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    public function setInstructions(string $instructions): static
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getAnalysedInstructions(): array
    {
        return $this->analysedInstructions;
    }

    public function setAnalysedInstructions(array $analysedInstructions): static
    {
        $this->analysedInstructions = $analysedInstructions;

        return $this;
    }

    public function getHealthScore(): ?int
    {
        return $this->healthScore;
    }

    public function setHealthScore(int $healthScore): static
    {
        $this->healthScore = $healthScore;

        return $this;
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    public function setIngredients(array $ingredients): static
    {
        $this->ingredients = $ingredients;

        return $this;
    }
}
