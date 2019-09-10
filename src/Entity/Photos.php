<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Photos
 *
 * @ORM\Table(name="photos", indexes={@ORM\Index(name="fk_photos_bal_id", columns={"bal_id"})})
 * @ORM\Entity
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
     * @ORM\Column(name="legende", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $legende = 'NULL';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime_post", type="datetime", nullable=false)
     */
    private $datetimePost;

    /**
     * @var \Balades
     *
     * @ORM\ManyToOne(targetEntity="Balades")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bal_id", referencedColumnName="id")
     * })
     */
    private $bal;


}
