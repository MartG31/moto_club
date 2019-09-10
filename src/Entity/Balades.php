<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Balades
 *
 * @ORM\Table(name="balades", indexes={@ORM\Index(name="fk_bal_user_id", columns={"user_id"})})
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

    /**
     * @var string|null
     *
     * @ORM\Column(name="file_gps", type="string", length=80, nullable=true, options={"default"="'NULL'"})
     */
    private $fileGps = '\'NULL\'';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime_post", type="datetime", nullable=false)
     */
    private $datetimePost;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datetime_modif", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $datetimeModif = 'NULL';

    /**
     * @var \Utilisateurs
     *
     * @ORM\ManyToOne(targetEntity="Utilisateurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


}
