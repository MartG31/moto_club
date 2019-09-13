<?php

namespace App\Repository;

use App\Entity\Reunions;
use App\Entity\ComptesRendus;
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


	public function findAllNotPast()
 	{
    return $this->createQueryBuilder('r')
            ->andWhere('r.datetimeReu < DateTime.Now')
            ->orderBy('r.dateReu', 'ASC')
            ->getQuery()
            ->getResult()
        ;

    }
    
    	// public function findReWithCr()
 // 	{
 //    return $this->createQueryBuilder('r')
 //            ->andWhere('r.datetimeReu < DateTime.Now')
 //            //->setParameter('val', $value)
 //            ->orderBy('r.dateReu', 'ASC')
 //            //->setMaxResults(10)
 //            ->getQuery()
 //            ->getResult()
 //        ;

 //    }

}

?>