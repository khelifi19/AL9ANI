<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentpub
 *
 * @ORM\Table(name="commentpub", indexes={@ORM\Index(name="id_pub", columns={"id_pub"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Commentpub
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_comment", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idComment;

    /**
     * @var string
     *
     * @ORM\Column(name="comment_pub", type="string", length=100, nullable=false)
     */
    private $commentPub;

    /**
     * @var \Publication
     *
     * @ORM\ManyToOne(targetEntity="Publication")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pub", referencedColumnName="id_pub")
     * })
     */
    private $idPub;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    public function getIdComment(): ?int
    {
        return $this->idComment;
    }

    public function getCommentPub(): ?string
    {
        return $this->commentPub;
    }

    public function setCommentPub(string $commentPub): self
    {
        $this->commentPub = $commentPub;

        return $this;
    }

    public function getIdPub(): ?Publication
    {
        return $this->idPub;
    }

    public function setIdPub(?Publication $idPub): self
    {
        $this->idPub = $idPub;

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


}
