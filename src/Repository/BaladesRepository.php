<?php

namespace App\Repository;

use App\Entity\Balades;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Balades|null find($id, $lockMode = null, $lockVersion = null)
 * @method Balades|null findOneBy(array $criteria, array $orderBy = null)
 * @method Balades[]    findAll()
 * @method Balades[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaladesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Balades::class);
    }
}

?>