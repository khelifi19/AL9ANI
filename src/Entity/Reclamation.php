<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idReclamation = null;

    #[ORM\Column(length: 255)]
    private ?string $titreReclamation = null;

    #[ORM\Column(length: 255)]
    private ?string $emailReclamation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionReclamation = null;

    public function getId(): ?int
    {
        return $this->idReclamation;
    }

    public function getTitreReclamation(): ?string
    {
        return $this->titreReclamation;
    }

    public function setTitreReclamation(string $titreReclamation): static
    {
        $this->titreReclamation = $titreReclamation;

        return $this;
    }

    public function getEmailReclamation(): ?string
    {
        return $this->emailReclamation;
    }

    public function setEmailReclamation(string $emailReclamation): static
    {
        $this->emailReclamation = $emailReclamation;

        return $this;
    }

    public function getDescriptionReclamation(): ?string
    {
        return $this->descriptionReclamation;
    }

    public function setDescriptionReclamation(string $descriptionReclamation): static
    {
        $this->descriptionReclamation = $descriptionReclamation;

        return $this;
    }
}
