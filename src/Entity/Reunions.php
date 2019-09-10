<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reunions
 *
 * @ORM\Table(name="reunions", indexes={@ORM\Index(name="fk_reu_user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Reunions
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=80, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=false)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime_reu", type="datetime", nullable=false)
     */
    private $datetimeReu;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_reu", type="string", length=80, nullable=false)
     */
    private $lieuReu;

    /**
     * @var string
     *
     * @ORM\Column(name="type_reu", type="string", length=30, nullable=false)
     */
    private $typeReu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime_post", type="datetime", nullable=false)
     */
    private $datetimePost;

    /**
     * @var \Utilisateurs
     *
     * @ORM\ManyToOne(targetEntity="Utilisateurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDatetimeReu(): ?\DateTimeInterface
    {
        return $this->datetimeReu;
    }

    public function setDatetimeReu(\DateTimeInterface $datetimeReu): self
    {
        $this->datetimeReu = $datetimeReu;

        return $this;
    }

    public function getLieuReu(): ?string
    {
        return $this->lieuReu;
    }

    public function setLieuReu(string $lieuReu): self
    {
        $this->lieuReu = $lieuReu;

        return $this;
    }

    public function getTypeReu(): ?string
    {
        return $this->typeReu;
    }

    public function setTypeReu(string $typeReu): self
    {
        $this->typeReu = $typeReu;

        return $this;
    }

    public function getDatetimePost(): ?\DateTimeInterface
    {
        return $this->datetimePost;
    }

    public function setDatetimePost(\DateTimeInterface $datetimePost): self
    {
        $this->datetimePost = $datetimePost;

        return $this;
    }

    public function getUser(): ?Utilisateurs
    {
        return $this->user;
    }

    public function setUser(?Utilisateurs $user): self
    {
        $this->user = $user;

        return $this;
    }


}
