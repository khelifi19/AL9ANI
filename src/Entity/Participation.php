<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Participation
 *
 * @ORM\Table(name="participation", indexes={@ORM\Index(name="fk_idUserPart", columns={"idUserPart"}), @ORM\Index(name="fk_idEvent", columns={"idEvent"})})
 * @ORM\Entity
 */
class Participation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idParticipation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idparticipation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateParticipation", type="date", nullable=false)
     */
    private $dateparticipation;

    /**
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEvent", referencedColumnName="idEvenement")
     * })
     */
    private $idevent;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUserPart", referencedColumnName="id_user")
     * })
     */
    private $iduserpart;

    public function getIdparticipation(): ?int
    {
        return $this->idparticipation;
    }

    public function getDateparticipation(): ?\DateTimeInterface
    {
        return $this->dateparticipation;
    }

    public function setDateparticipation(\DateTimeInterface $dateparticipation): self
    {
        $this->dateparticipation = $dateparticipation;

        return $this;
    }

    public function getIdevent(): ?Evenement
    {
        return $this->idevent;
    }

    public function setIdevent(?Evenement $idevent): self
    {
        $this->idevent = $idevent;

        return $this;
    }

    public function getIduserpart(): ?User
    {
        return $this->iduserpart;
    }

    public function setIduserpart(?User $iduserpart): self
    {
        $this->iduserpart = $iduserpart;

        return $this;
    }


}
