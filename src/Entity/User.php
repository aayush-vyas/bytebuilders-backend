<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`', schema: 'user_management')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    const ROLE_USER =  "ROLE_USER";
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $username = null;

    #[ORM\Column(length: 512, nullable: true)]
    private ?string $profilePicture = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $lastLogin = null;

    /**
     * @var Collection<int, Diet>
     */
    #[ORM\ManyToMany(targetEntity: Diet::class)]
    #[ORM\JoinTable(schema: 'user_management')]
    private Collection $diets;
    
    /**
     * @var Collection<int, Allergies>
     */
    #[ORM\ManyToMany(targetEntity: Allergies::class)]
    #[ORM\JoinTable(schema: 'user_management')]
    private Collection $allergies;

    public function __construct()
    {
        $this->diets = new ArrayCollection();
        $this->allergies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture): static
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(\DateTimeInterface $lastLogin): static
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * @return Collection<int, Diet>
     */
    public function getDiets(): Collection
    {
        return $this->diets;
    }

    public function addDiet(Diet $diet): static
    {
        if (!$this->diets->contains($diet)) {
            $this->diets->add($diet);
        }

        return $this;
    }

    public function removeDiet(Diet $diet): static
    {
        $this->diets->removeElement($diet);

        return $this;
    }

    /**
     * @return Collection<int, Allergies>
     */
    public function getAllergies(): Collection
    {
        return $this->allergies;
    }

    public function addAllergy(Allergies $allergy): static
    {
        if (!$this->allergies->contains($allergy)) {
            $this->allergies->add($allergy);
        }

        return $this;
    }

    public function removeAllergy(Allergies $allergy): static
    {
        $this->allergies->removeElement($allergy);

        return $this;
    }

    public function getRoles(): array
    {
        $roles[] = User::ROLE_USER;

        return array_unique($roles);    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
}
