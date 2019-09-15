<?php

namespace App\Repository;

use App\Entity\Balades;
use App\Entity\MembresBalades;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MembresBalades|null find($id, $lockMode = null, $lockVersion = null)
 * @method MembresBalades|null findOneBy(array $criteria, array $orderBy = null)
 * @method MembresBalades[]    findAll()
 * @method MembresBalades[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MembresBaladesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MembresBalades::class);
    }

    public function countInscrits(Balades $balade) {

    	return $this->createQueryBuilder('mb')
    			->select('count(mb.id) as count')
    	        ->andWhere('mb.bal = :balade')
    	        ->setParameter('balade', $balade)
    	        ->getQuery()
    	        ->getOneOrNullResult();
    }
}

?>