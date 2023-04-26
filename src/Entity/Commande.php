<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_prod", columns={"id_prod"}), @ORM\Index(name="fk_panier", columns={"id_panier"})})
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_commande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommande;

    /**
     * @var int|null
     *
     * @ORM\Column(name="totale", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $totale = NULL;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="valide", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $valide = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=250, nullable=false)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="d", type="date", nullable=false, options={"default"="current_timestamp()"})
     */
    private $d = 'current_timestamp()';

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=false)
     */
    private $mail;

    /**
     * @var \PanierProduit
     *
     * @ORM\ManyToOne(targetEntity="PanierProduit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_panier", referencedColumnName="id")
     * })
     */
    private $idPanier;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @var \Produits
     *
     * @ORM\ManyToOne(targetEntity="Produits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_prod", referencedColumnName="id_product")
     * })
     */
    private $idProd;

    public function getIdCommande(): ?int
    {
        return $this->idCommande;
    }

    public function getTotale(): ?int
    {
        return $this->totale;
    }

    public function setTotale(?int $totale): self
    {
        $this->totale = $totale;

        return $this;
    }

    public function isValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(?bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getD(): ?\DateTimeInterface
    {
        return $this->d;
    }

    public function setD(\DateTimeInterface $d): self
    {
        $this->d = $d;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getIdPanier(): ?PanierProduit
    {
        return $this->idPanier;
    }

    public function setIdPanier(?PanierProduit $idPanier): self
    {
        $this->idPanier = $idPanier;

        return $this;
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

    public function getIdProd(): ?Produits
    {
        return $this->idProd;
    }

    public function setIdProd(?Produits $idProd): self
    {
        $this->idProd = $idProd;

        return $this;
    }


}
