<?php

namespace App\Repository;

use App\Entity\Reunions;
// use App\Entity\ComptesRendus;
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


    /**
     * @return Reunions[] Returns an array of Reunions objects
     */
	public function findAllNotPast($param = null)
 	{
        return $this->createQueryBuilder('r')
                ->andWhere('r.datetimeReu > :datecourant')
                ->setParameter('datecourant', new \Datetime())
                ->orderBy('r.datetimeReu', 'DESC')
                ->getQuery()
                ->getResult();
    }

     /**
     * @return Reunions[] Returns an array of Reunions objects
     */
    public function findAllPast($param = null)
    {
        return $this->createQueryBuilder('r')
                ->andWhere('r.datetimeReu < :datecourant')
                ->setParameter('datecourant', new \Datetime())
                ->orderBy('r.datetimeReu', 'DESC')
                ->getQuery()
                ->getResult();
    }


    /**
     * @return Reunions[] Returns an array of Reunions objects
     */
    public function findLastNotPast($param = null)
    {
        return $this->createQueryBuilder('r')
                ->andWhere('r.datetimeReu > :datecourant')
                ->setParameter('datecourant', new \Datetime())
                ->orderBy('r.datetimeReu', 'DESC')
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleResult();

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

    // /**
    //  * @return Flag[] Returns an array of Flag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Flag
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}

?>