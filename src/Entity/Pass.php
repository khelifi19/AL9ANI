<?php

namespace App\Entity;

use App\Repository\PassRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PassRepository::class)]
class Pass
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idPass = null;


    #[ORM\Column]
    private ?int $prixPass = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

  

    public function getId(): ?int
    {
        return $this->idPass;
    }

    public function getPrixPass(): ?float
    {
        return $this->prixPass;
    }

    public function setPrixPass(float $prixPass): static
    {
        $this->prixPass = $prixPass;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

  
}