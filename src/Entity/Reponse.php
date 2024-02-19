<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "text")]
    private ?string $contenuReponse = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Reclamation $reclamation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenuReponse(): ?string
    {
        return $this->contenuReponse;
    }

    public function setContenuReponse(string $contenuReponse): static
    {
        $this->contenuReponse = $contenuReponse;

        return $this;
    }

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(?Reclamation $reclamation): static
    {
        $this->reclamation = $reclamation;

        return $this;
    }
}

