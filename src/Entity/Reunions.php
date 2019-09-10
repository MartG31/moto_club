<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reunions
 *
 * @ORM\Table(name="reunions")
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
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }


}
