<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tokens
 *
 * @ORM\Table(name="tokens", indexes={@ORM\Index(name="fk_tok_user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Tokens
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
     * @ORM\Column(name="token", type="string", length=160, nullable=false)
     */
    private $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime_token", type="datetime", nullable=false)
     */
    private $datetimeToken;

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
