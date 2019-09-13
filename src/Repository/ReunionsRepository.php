<?php

namespace App\Repository;

use App\Entity\Reunions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Reunions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reunions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reunions[]    findAll()
 * @method Reunions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReunionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reunions::class);
    }


    public function findAllWithCr()
    {


    }
}

?>