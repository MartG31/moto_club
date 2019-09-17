<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Photos
 *
 * @ORM\Table(name="photos", indexes={@ORM\Index(name="fk_photos_bal_id", columns={"bal_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\PhotosRepository")
 */
class Photos
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
     * @ORM\Column(name="file_name", type="string", length=80, nullable=false)
     */
    private $fileName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="legende", type="string", length=50, nullable=true)
     */
    private $legende;

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

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getLegende(): ?string
    {
        return $this->legende;
    }

    public function setLegende(?string $legende): self
    {
        $this->legende = $legende;

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
