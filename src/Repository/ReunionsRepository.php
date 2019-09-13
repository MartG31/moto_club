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


	// public function findAllNotPast()
 // 	{
 //    return $this->createQueryBuilder('f')
 //            ->andWhere('f.dateReu < NOW')
 //            //->setParameter('val', $value)
 //            ->orderBy('f.dateReu', 'ASC')
 //            //->setMaxResults(10)
 //            ->getQuery()
 //            ->getResult()
 //        ;

 //    }

}

?>