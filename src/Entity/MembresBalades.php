<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MembresBalades
 *
 * @ORM\Table(name="membres_balades", indexes={@ORM\Index(name="fk_mb_user_id", columns={"user_id"}), @ORM\Index(name="fk_mb_bal_id", columns={"bal_id"})})
 * @ORM\Entity
 */
class MembresBalades
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Balades
     *
     * @ORM\ManyToOne(targetEntity="Balades")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bal_id", referencedColumnName="id")
     * })
     */
    private $bal;

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
