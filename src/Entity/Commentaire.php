<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
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

    #[ORM\Column(type: 'date')] // Ajout de l'attribut datepost de type date
    private ?\DateTimeInterface $datecom = null;

   
    #[ORM\ManyToOne]
    private ?Post $post = null;

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

    public function getDatecom(): ?\DateTimeInterface
    {
        return $this->datecom;
    }

    public function setDatecom(\DateTimeInterface $datecom): static
    {
        $this->datecom = $datecom;

        return $this;
    }

   

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): static
    {
        $this->post = $post;

        return $this;
    }
    public function __construct()
    {
        // Set $datecom to the current date when the object is created
        $this->datecom = new \DateTime();
    }
}
