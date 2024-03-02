<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThan("today", message:"La date doit être postérieure à la date actuelle.")]
    private ?\DateTimeInterface $dateReservation = null;

    #[ORM\Column]
    #[Assert\Range(min:1, max:99, notInRangeMessage:"Ce nombre doit être compris entre {{ min }} et {{ max }}.")]
    private ?int $nombreDePersonnes = null;


    #[ORM\ManyToOne(inversedBy: 'reservation')]
    private ?Etablissements $etablissements = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): static
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    public function getNombreDePersonnes(): ?int
    {
        return $this->nombreDePersonnes;
    }

    public function setNombreDePersonnes(int $nombreDePersonnes): static
    {
        $this->nombreDePersonnes = $nombreDePersonnes;

        return $this;
    }

    public function getEtablissements(): ?Etablissements
    {
        return $this->etablissements;
    }

    public function setEtablissements(?Etablissements $etablissements): static
    {
        $this->etablissements = $etablissements;

        return $this;
    }
}
