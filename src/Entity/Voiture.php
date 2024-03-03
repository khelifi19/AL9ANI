<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]

#[ORM\Table()]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le modèle ne doit pas être vide")]
    #[Assert\Choice(
        choices: ["Bus","Classique"],
        message: "Le modèle doit être soit 'Bus' soit 'Classique'"
    )]
    private ?string $modele = null;

   

    #[ORM\Column]

    private ?int $nbPlace = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "La disponibilité ne peut pas être vide")]
    private ?bool $disponibilite = null;
   
    #[ORM\Column(length: 255, unique: true)]

 
    #[Assert\NotBlank(message: "La matricule ne doit pas être vide")]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: "La matricule doit comporter au moins {{ limit }} caractères",
        maxMessage: "La matricule ne peut pas dépasser {{ limit }} caractères"
    )]
    #[Assert\Regex(
        pattern: "^\d+\d* TU \d+\d*$^",
        message: "La matricule doit commencer par un nombre, suivi de 'TU', et se terminer par au moins un chiffre"
    )]
    private ?string $matricule = null;

    #[ORM\OneToMany(targetEntity: Course::class, mappedBy: 'idVoiture', cascade: ["remove"])]
    private Collection $courses;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La description ne doit pas être vide")]
    #[Assert\Length(
        min: 4,
        max: 255,
        minMessage: "La description doit comporter au moins {{ limit }} caractères",
        maxMessage: "La description ne peut pas dépasser {{ limit }} caractères"
    )]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'voitures')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Chauffeur $chauffeur = null;

   


     
 

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

   

    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    public function setNbPlace(int $nbPlace): static
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    public function isDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(bool $disponibilite): static
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->setIdVoiture($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): static
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getIdVoiture() === $this) {
                $course->setIdVoiture(null);
            }
        }

        return $this;
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
    // Dans la classe Voiture
public function __toString(): string
{
    return $this->modele; // Ou toute autre propriété de la voiture que vous souhaitez afficher
}

public function getChauffeur(): ?Chauffeur
{
    return $this->chauffeur;
}

public function setChauffeur(?Chauffeur $chauffeur): static
{
    $this->chauffeur = $chauffeur;

    return $this;
}



public function isDisponibleAtDate(\DateTime $date): bool
{
    // Créer une copie de la date spécifiée
    $DC = new \DateTime($date->format('Y-m-d H:i:s'));

    // Ajouter deux heures à la date modifiée
    $FC = new \DateTime($DC->format('Y-m-d H:i:s'));
    $FC->add(new \DateInterval("PT2H"));

    // Parcourir les courses associées à cette voiture
    foreach ($this->courses as $course) {
        // Créer un objet DateTime à partir de la date de début de la course
        $DD = new \DateTime($course->getDate()->format('Y-m-d H:i:s'));

        // Ajouter deux heures à la date de début de la course pour obtenir la date de fin
        $DF = new \DateTime($DD->format('Y-m-d H:i:s'));
        $DF->add(new \DateInterval("PT2H"));
        
        // Vérifier si les plages horaires des réservations se chevauchent
        if (($DC >= $DD && $DC < $DF) || ($FC > $DD && $FC <= $DF)) {
            // La voiture n'est pas disponible à cette date
            return false;
        }
    }
    
    return true; // La voiture est disponible à cette date
}


}