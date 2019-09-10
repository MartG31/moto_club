<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Balades
 *
 * @ORM\Table(name="balades")
 * @ORM\Entity
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
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

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
     * @var \DateTime|null
     *
     * @ORM\Column(name="datetime_rdv", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $datetimeRdv = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse_rdv", type="string", length=120, nullable=true, options={"default"="NULL"})
     */
    private $adresseRdv = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="cp_rdv", type="string", length=10, nullable=true, options={"default"="NULL"})
     */
    private $cpRdv = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville_rdv", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $villeRdv = 'NULL';

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getDatetimeRdv(): ?\DateTimeInterface
    {
        return $this->datetimeRdv;
    }

    public function setDatetimeRdv(?\DateTimeInterface $datetimeRdv): self
    {
        $this->datetimeRdv = $datetimeRdv;

        return $this;
    }

    public function getAdresseRdv(): ?string
    {
        return $this->adresseRdv;
    }

    public function setAdresseRdv(?string $adresseRdv): self
    {
        $this->adresseRdv = $adresseRdv;

        return $this;
    }

    public function getCpRdv(): ?string
    {
        return $this->cpRdv;
    }

    public function setCpRdv(?string $cpRdv): self
    {
        $this->cpRdv = $cpRdv;

        return $this;
    }

    public function getVilleRdv(): ?string
    {
        return $this->villeRdv;
    }

    public function setVilleRdv(?string $villeRdv): self
    {
        $this->villeRdv = $villeRdv;

        return $this;
    }


}
