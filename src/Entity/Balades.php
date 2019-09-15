<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Balades
 *
 * @ORM\Table(name="balades", indexes={@ORM\Index(name="fk_bal_user_id", columns={"user_id"})})
  * @ORM\Entity(repositoryClass="App\Repository\BaladesRepository")
 */
class Balades
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
     * @ORM\Column(name="titre", type="string", length=120, nullable=false)
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
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="file_gps", type="string", length=80, nullable=true)
     */
    private $fileGps;

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
     * @var \Utilisateurs
     *
     * @ORM\ManyToOne(targetEntity="Utilisateurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_max_pers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bal_active;

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getFileGps(): ?string
    {
        return $this->fileGps;
    }

    public function setFileGps(?string $fileGps): self
    {
        $this->fileGps = $fileGps;

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

    public function getUser(): ?Utilisateurs
    {
        return $this->user;
    }

    public function setUser(?Utilisateurs $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getNbMaxPers(): ?int
    {
        return $this->nb_max_pers;
    }

    public function setNbMaxPers(?int $nb_max_pers): self
    {
        $this->nb_max_pers = $nb_max_pers;

        return $this;
    }

    public function getBalActive(): ?bool
    {
        return $this->bal_active;
    }

    public function setBalActive(bool $bal_active): self
    {
        $this->bal_active = $bal_active;

        return $this;
    }


}
