<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


/**
 * @Assert\NotBlank(message="Le champ  ne doit pas être vide.")
 */

    #[ORM\Column(length: 255)]
    private ?string $description = null;

/**
 * @Assert\NotBlank(message="Le champ  ne doit pas être vide.")
 * @Assert\Regex(
 *     pattern="/^[a-zA-Z]*$/",
 *     message="Le champ doit contenir uniquement des lettres."
 * )
 */

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    /**
 * @Assert\NotBlank(message="Le champ  ne doit pas être vide.")
 */
    #[ORM\Column(length: 255)]
    private ?string $localisation = null;


    #[ORM\Column(type: 'date')] // Ajout de l'attribut datepost de type date
    private ?\DateTimeInterface $datepost = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: "boolean", nullable: true)]
    #[Groups("post:read")]
    private bool $enable = false;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDatepost(): ?\DateTimeInterface
    {
        return $this->datepost;
    }

    public function setDatepost(\DateTimeInterface $datepost): static
    {
        $this->datepost = $datepost;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function __construct()
    {
        // Set $datecom to the current date when the object is created
        $this->datepost = new \DateTime();
    }

    public function __toString() {
        return $this->getId(); // or any other logic to represent the object as a string
    }
    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(?bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }
}
