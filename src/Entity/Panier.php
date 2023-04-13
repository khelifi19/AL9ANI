<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier", indexes={@ORM\Index(name="fk_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Panier
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_pannier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPannier;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    public function getIdPannier(): ?int
    {
        return $this->idPannier;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
