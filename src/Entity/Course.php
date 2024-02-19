<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column(length: 255)]
    #[Assert\NotNull(message: "La destination ne doit pas être vide")]
    #[Assert\Type(type: 'string', message: "La destination doit être une chaîne de caractères")]
    #[Assert\Length(min: 2, max: 255, minMessage: "La destination doit contenir au moins {{ limit }} caractères", maxMessage: "La destination ne peut pas dépasser {{ limit }} caractères")]
    private ?string $destination = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull(message: "Le départ ne doit pas être vide")]
    #[Assert\Type(type: 'string', message: "Le départ doit être une chaîne de caractères")]
    #[Assert\Length(min: 2, max: 255, minMessage: "Le départ doit contenir au moins 4 caractères", maxMessage: "Le départ ne peut pas dépasser 30 caractères")]
    private ?string $depart = null;

    

    #[ORM\Column]
    #[Assert\NotNull(message: "Le nombre de personnes ne doit pas être vide")]
    #[Assert\Range(
        min:1,
        max:9,
        
        minMessage: "Le nombre de personnes doit être au moins 1",
        maxMessage:"Le nombre de personnes ne peut pas dépasser 9")]
    #[Assert\Type(type: 'integer', message: "Le nombre de personnes doit être un entier")]
    private ?int $nbPersonne = null;


 

    #[ORM\ManyToOne(inversedBy: 'courses')]
    #[ORM\JoinColumn(nullable: false)]
   
    private ?Voiture $idVoiture = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThanOrEqual("now", message:"La date doit être supérieure ou égale à la date actuelle")]
    #[ Assert\LessThanOrEqual("+1 year", message:"La date doit être inférieure ou égale à la date actuelle plus un an")]
  
    private ?\DateTimeInterface $date = null;

    




  

    public function getId(): ?int
    {
        return $this->id;
    }

  


    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDepart(): ?string
    {
        return $this->depart;
    }

    public function setDepart(string $depart): static
    {
        $this->depart = $depart;

        return $this;
    }

    

    public function getNbPersonne(): ?int
    {
        return $this->nbPersonne;
    }

    public function setNbPersonne(int $nbPersonne): static
    {
        $this->nbPersonne = $nbPersonne;

        return $this;
    }

  

    public function getIdVoiture(): ?Voiture
    {
        return $this->idVoiture;
    }

    public function setIdVoiture(?Voiture $idVoiture): static
    {
        $this->idVoiture = $idVoiture;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

  



    
}
