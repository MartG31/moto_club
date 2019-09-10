<?php

namespace App\Repository;

use App\Entity\ComptesRendus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ComptesRendus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComptesRendus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComptesRendus[]    findAll()
 * @method ComptesRendus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComptesRendusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComptesRendus::class);
    }
}

?>