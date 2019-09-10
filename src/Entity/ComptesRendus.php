<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ComptesRendus
 *
 * @ORM\Table(name="comptes_rendus", indexes={@ORM\Index(name="fk_cr_reu_id", columns={"reu_id"})})
 * @ORM\Entity
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
     * @var \Reunions
     *
     * @ORM\ManyToOne(targetEntity="Reunions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reu_id", referencedColumnName="id")
     * })
     */
    private $reu;

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

    public function getReu(): ?Reunions
    {
        return $this->reu;
    }

    public function setReu(?Reunions $reu): self
    {
        $this->reu = $reu;

        return $this;
    }


}
