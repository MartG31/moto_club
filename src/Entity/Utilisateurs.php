<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateurs
 *
 * @ORM\Table(name="utilisateurs", uniqueConstraints={@ORM\UniqueConstraint(name="unique_email", columns={"email"})})
 * @ORM\Entity
 */
class Utilisateurs
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
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="pwd", type="string", length=80, nullable=false)
     */
    private $pwd;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pseudo", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $pseudo = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $nom = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="prenom", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $prenom = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="avatar", type="string", length=120, nullable=true, options={"default"="NULL"})
     */
    private $avatar = 'NULL';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime_inscription", type="datetime", nullable=false)
     */
    private $datetimeInscription;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datetime_adhesion", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $datetimeAdhesion = 'NULL';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPwd(): ?string
    {
        return $this->pwd;
    }

    public function setPwd(string $pwd): self
    {
        $this->pwd = $pwd;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getDatetimeInscription(): ?\DateTimeInterface
    {
        return $this->datetimeInscription;
    }

    public function setDatetimeInscription(\DateTimeInterface $datetimeInscription): self
    {
        $this->datetimeInscription = $datetimeInscription;

        return $this;
    }

    public function getDatetimeAdhesion(): ?\DateTimeInterface
    {
        return $this->datetimeAdhesion;
    }

    public function setDatetimeAdhesion(?\DateTimeInterface $datetimeAdhesion): self
    {
        $this->datetimeAdhesion = $datetimeAdhesion;

        return $this;
    }


}
