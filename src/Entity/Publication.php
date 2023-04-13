<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table(name="publication", indexes={@ORM\Index(name="id_userB", columns={"id_userB"})})
 * @ORM\Entity
 */
class Publication
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_pub", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPub;

    /**
     * @var string
     *
     * @ORM\Column(name="titre_pub", type="string", length=50, nullable=false)
     */
    private $titrePub;

    /**
     * @var string
     *
     * @ORM\Column(name="texte_pub", type="string", length=50, nullable=false)
     */
    private $textePub;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_pub", type="string", length=50, nullable=false)
     */
    private $photoPub;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_pub", type="date", nullable=false, options={"default"="current_timestamp()"})
     */
    private $datePub = 'current_timestamp()';

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_userB", referencedColumnName="id_user")
     * })
     */
    private $idUserb;

    public function getIdPub(): ?int
    {
        return $this->idPub;
    }

    public function getTitrePub(): ?string
    {
        return $this->titrePub;
    }

    public function setTitrePub(string $titrePub): self
    {
        $this->titrePub = $titrePub;

        return $this;
    }

    public function getTextePub(): ?string
    {
        return $this->textePub;
    }

    public function setTextePub(string $textePub): self
    {
        $this->textePub = $textePub;

        return $this;
    }

    public function getPhotoPub(): ?string
    {
        return $this->photoPub;
    }

    public function setPhotoPub(string $photoPub): self
    {
        $this->photoPub = $photoPub;

        return $this;
    }

    public function getDatePub(): ?\DateTimeInterface
    {
        return $this->datePub;
    }

    public function setDatePub(\DateTimeInterface $datePub): self
    {
        $this->datePub = $datePub;

        return $this;
    }

    public function getIdUserb(): ?User
    {
        return $this->idUserb;
    }

    public function setIdUserb(?User $idUserb): self
    {
        $this->idUserb = $idUserb;

        return $this;
    }


}
