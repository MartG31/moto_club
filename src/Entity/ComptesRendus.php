<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ComptesRendus
 *
 * @ORM\Table(name="comptes_rendus", indexes={@ORM\Index(name="fk_cr_user_id", columns={"user_id"}), @ORM\Index(name="fk_cr_reu_id", columns={"reu_id"})})
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
     * @var \Reunions
     *
     * @ORM\ManyToOne(targetEntity="Reunions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reu_id", referencedColumnName="id")
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


}
