<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ComptesRendus
 *
 * @ORM\Table(name="comptes_rendus", indexes={@ORM\Index(name="fk_cr_user_id", columns={"user_id"}), @ORM\Index(name="fk_cr_reu_id", columns={"reu_id"})})
  * @ORM\Entity(repositoryClass="App\Repository\ComptesRendusRepository")
 */
class ComptesRendus
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
     * @ORM\Column(name="datetime_post", type="datetime", nullable=false)
     */
    private $datetimePost;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datetime_modif", type="datetime", nullable=true)
     */
    private $datetimeModif;

    /**
     * @var \Reunions
     *
     * @ORM\ManyToOne(targetEntity="Reunions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reu_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $reu;

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

    public function getDatetimePost(): ?\DateTimeInterface
    {
        return $this->datetimePost;
    }

    public function setDatetimePost(\DateTimeInterface $datetimePost): self
    {
        $this->datetimePost = $datetimePost;

        return $this;
    }

    public function getDatetimeModif(): ?\DateTimeInterface
    {
        return $this->datetimeModif;
    }

    public function setDatetimeModif(?\DateTimeInterface $datetimeModif): self
    {
        $this->datetimeModif = $datetimeModif;

        return $this;
    }

    public function getReu(): ?Reunions
    {
        return $this->reu;
    }

    public function setReu(?Reunions $reu): self
    {
        $this->reu = $reu;

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
