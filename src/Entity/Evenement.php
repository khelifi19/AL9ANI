<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="id_userE", columns={"id_userE"})})
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEvenement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idevenement;

    /**
     * @var string
     *
     * @ORM\Column(name="nomEvenement", type="string", length=255, nullable=false)
     */
    private $nomevenement;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionEvenement", type="string", length=255, nullable=false)
     */
    private $descriptionevenement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEvenement", type="date", nullable=false)
     */
    private $dateevenement;

    /**
     * @var float
     *
     * @ORM\Column(name="prixEvenement", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixevenement;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreParticipantMax", type="integer", nullable=false)
     */
    private $nbreparticipantmax;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbreParticipant", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $nbreparticipant = NULL;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_userE", referencedColumnName="id_user")
     * })
     */
    private $idUsere;

    public function getIdevenement(): ?int
    {
        return $this->idevenement;
    }

    public function getNomevenement(): ?string
    {
        return $this->nomevenement;
    }

    public function setNomevenement(string $nomevenement): self
    {
        $this->nomevenement = $nomevenement;

        return $this;
    }

    public function getDescriptionevenement(): ?string
    {
        return $this->descriptionevenement;
    }

    public function setDescriptionevenement(string $descriptionevenement): self
    {
        $this->descriptionevenement = $descriptionevenement;

        return $this;
    }

    public function getDateevenement(): ?\DateTimeInterface
    {
        return $this->dateevenement;
    }

    public function setDateevenement(\DateTimeInterface $dateevenement): self
    {
        $this->dateevenement = $dateevenement;

        return $this;
    }

    public function getPrixevenement(): ?float
    {
        return $this->prixevenement;
    }

    public function setPrixevenement(float $prixevenement): self
    {
        $this->prixevenement = $prixevenement;

        return $this;
    }

    public function getNbreparticipantmax(): ?int
    {
        return $this->nbreparticipantmax;
    }

    public function setNbreparticipantmax(int $nbreparticipantmax): self
    {
        $this->nbreparticipantmax = $nbreparticipantmax;

        return $this;
    }

    public function getNbreparticipant(): ?int
    {
        return $this->nbreparticipant;
    }

    public function setNbreparticipant(?int $nbreparticipant): self
    {
        $this->nbreparticipant = $nbreparticipant;

        return $this;
    }

    public function getIdUsere(): ?User
    {
        return $this->idUsere;
    }

    public function setIdUsere(?User $idUsere): self
    {
        $this->idUsere = $idUsere;

        return $this;
    }


}
