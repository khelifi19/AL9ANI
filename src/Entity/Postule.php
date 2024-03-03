<?php

namespace App\Entity;

use App\Repository\PostuleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: PostuleRepository::class)]
class Postule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide")]
    #[Assert\Length(
        min: 3,
        minMessage: "Le nom doit comporter au moins 3 caractères"
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-ZÀ-ÿ\s]+$/',
        message: "Le nom ne peut contenir que des lettres"
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le prenom ne peut pas être vide")]
    #[Assert\Length(
        min: 3,
        minMessage: "Le prenom doit comporter au moins 3 caractères"
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-ZÀ-ÿ\s]+$/',
        message: "Le prenom ne peut contenir que des lettres"
    )]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;



    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^(9|5|2)\d{7}$/',
        message: "Saisir un numero de telephone valide"
    )]
    private ?string $numero = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'email ne peut pas être vide")]
#[Assert\Email(
    message: "L'email '{{ value }}' n'est pas valide.",
    mode: 'html5'
)]
    private ?string $email = null;

    #[ORM\Column]
  
    #[Assert\NotBlank(message: "L'âge ne peut pas être vide")]
    #[Assert\Range(
        min: 20,
        max: 45,
        minMessage: "L'âge doit être d'au moins 20",
        maxMessage: "L'âge ne peut pas dépasser 45"
    )]
 
    private ?int $age = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

  



    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }
}
