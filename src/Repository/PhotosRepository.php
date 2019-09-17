<?php

namespace App\Repository;

use App\Entity\Photos;
use App\Entity\Balades;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Photos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Photos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Photos[]    findAll()
 * @method Photos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photos::class);
    }

    public function countPhotosByBalade(Balades $balade) {

    	return $this->createQueryBuilder('p')
    			->select('count(p.id) as count')
    	        ->andWhere('p.bal = :balade')
    	        ->setParameter('balade', $balade)
    	        ->getQuery()
    	        ->getOneOrNullResult();
    }
}

?>