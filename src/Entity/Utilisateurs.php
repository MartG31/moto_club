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
     * @var int
     *
     * @ORM\Column(name="acces", type="integer", nullable=false)
     */
    private $acces;

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


}
