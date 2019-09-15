<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adresses
 *
 * @ORM\Table(name="adresses", indexes={@ORM\Index(name="fk_adresses_bal_id", columns={"bal_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\AdressesRepository")
 */
class Adresses
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
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $type;

    /**
     * @var \Balades
     *
     * @ORM\ManyToOne(targetEntity="Balades")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bal_id", referencedColumnName="id")
     * })
     */
    private $bal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getBal(): ?Balades
    {
        return $this->bal;
    }

    public function setBal(?Balades $bal): self
    {
        $this->bal = $bal;

        return $this;
    }
}
