<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solde
 *
 * @ORM\Table(name="solde", indexes={@ORM\Index(name="id_produit", columns={"id_produit"})})
 * @ORM\Entity
 */
class Solde
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_solde", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSolde;

    /**
     * @var int
     *
     * @ORM\Column(name="taux", type="integer", nullable=false)
     */
    private $taux;

    /**
     * @var \Produits
     *
     * @ORM\ManyToOne(targetEntity="Produits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_produit", referencedColumnName="id_product")
     * })
     */
    private $idProduit;

    public function getIdSolde(): ?int
    {
        return $this->idSolde;
    }

    public function getTaux(): ?int
    {
        return $this->taux;
    }

    public function setTaux(int $taux): self
    {
        $this->taux = $taux;

        return $this;
    }

    public function getIdProduit(): ?Produits
    {
        return $this->idProduit;
    }

    public function setIdProduit(?Produits $idProduit): self
    {
        $this->idProduit = $idProduit;

        return $this;
    }


}
