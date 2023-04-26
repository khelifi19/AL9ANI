<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Categorie;


/**
 * Produits
 *
 * @ORM\Table(name="produits", indexes={@ORM\Index(name="related_artist", columns={"related_artist"}), @ORM\Index(name="category", columns={"category"})})
 * @ORM\Entity
 */
class Produits
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_product", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduct;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=250, nullable=false)
     */
    private $productName;

    /**
     * @var string
     *
     * @ORM\Column(name="product_description", type="text", length=65535, nullable=false)
     */
    private $productDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="product_photo", type="string", length=250, nullable=false)
     */
    private $productPhoto;

    /**
     * @var float
     *
     * @ORM\Column(name="product_price", type="float", precision=10, scale=0, nullable=false)
     */
    private $productPrice;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="addeddate", type="date", nullable=true, options={"default"="current_timestamp()"})
     */
    private $addeddate = 'current_timestamp()';

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="related_artist", referencedColumnName="id_user")
     * })
     */
    private $relatedArtist;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category", referencedColumnName="id")
     * })
     */
    private $category;

    public function getIdProduct(): ?int
    {
        return $this->idProduct;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->productDescription;
    }

    public function setProductDescription(string $productDescription): self
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    public function getProductPhoto(): ?string
    {
        return $this->productPhoto;
    }

    public function setProductPhoto(string $productPhoto): self
    {
        $this->productPhoto = $productPhoto;

        return $this;
    }

    public function getProductPrice(): ?float
    {
        return $this->productPrice;
    }

    public function setProductPrice(float $productPrice): self
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    public function getAddeddate(): ?\DateTimeInterface
    {
        return $this->addeddate;
    }

    public function setAddeddate(?\DateTimeInterface $addeddate): self
    {
        $this->addeddate = $addeddate;

        return $this;
    }

    public function getRelatedArtist(): ?User
    {
        return $this->relatedArtist;
    }

    public function setRelatedArtist(?User $relatedArtist): self
    {
        $this->relatedArtist = $relatedArtist;

        return $this;
    }

    public function getCategory(): ?Categorie
    {
        return $this->category;
    }

    public function setCategory(?Categorie $category): self
    {
        $this->category = $category;

        return $this;
    }


}
