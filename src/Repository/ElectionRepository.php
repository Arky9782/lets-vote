<?php

namespace App\Repository;

use App\Entity\Election;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Election|null find($id, $lockMode = null, $lockVersion = null)
 * @method Election|null findOneBy(array $criteria, array $orderBy = null)
 * @method Election[]    findAll()
 * @method Election[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Election::class);
    }

    // /**
    //  * @return Election[] Returns an array of Election objects
    //  */

    public function findByHash(string $hash)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.hash = :val')
            ->setParameter('val', $hash)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Election
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
