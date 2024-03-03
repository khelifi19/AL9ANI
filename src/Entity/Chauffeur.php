<?php

namespace App\Entity;

use App\Repository\ChauffeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ChauffeurRepository::class)]
class Chauffeur
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

    #[ORM\Column]
    #[Assert\NotBlank(message: "L'âge ne peut pas être vide")]
    #[Assert\Range(
        min: 20,
        max: 45,
        minMessage: "L'âge doit être d'au moins 20",
        maxMessage: "L'âge ne peut pas dépasser 45"
    )]
    private ?int $age = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^(9|5|2)\d{7}$/',
        message: "Saisir un numero de telephone valide"
    )]
    private ?string $numero = null;


    #[ORM\OneToMany(targetEntity: Voiture::class, mappedBy: 'chauffeur')]
    private Collection $voitures;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le salaire ne peut pas être vide")]
#[Assert\Range(
    min: 100,
    max: 10000,
    minMessage: "Le salaire minimum doit être de 100",
    maxMessage: "Le salaire maximum ne peut pas dépasser 10000"
)]
    private ?float $salaire = null;

    public function __construct()
    {
        $this->voitures = new ArrayCollection();
    }

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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

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

    /**
     * @return Collection<int, Voiture>
     */
    public function getVoitures(): Collection
    {
        return $this->voitures;
    }

    public function addVoiture(Voiture $voiture): static
    {
        if (!$this->voitures->contains($voiture)) {
            $this->voitures->add($voiture);
            $voiture->setChauffeur($this);
        }

        return $this;
    }

    public function removeVoiture(Voiture $voiture): static
    {
        if ($this->voitures->removeElement($voiture)) {
            // set the owning side to null (unless already changed)
            if ($voiture->getChauffeur() === $this) {
                $voiture->setChauffeur(null);
            }
        }

        return $this;
    }

    public function getSalaire(): ?float
    {
        return $this->salaire;
    }

    public function setSalaire(float $salaire): static
    {
        $this->salaire = $salaire;

        return $this;
    }
}
