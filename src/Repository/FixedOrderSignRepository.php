<?php

namespace App\Repository;

use App\Entity\FixedOrderSign;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FixedOrderSign|null find($id, $lockMode = null, $lockVersion = null)
 * @method FixedOrderSign|null findOneBy(array $criteria, array $orderBy = null)
 * @method FixedOrderSign[]    findAll()
 * @method FixedOrderSign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FixedOrderSignRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FixedOrderSign::class);
    }

    // /**
    //  * @return FixedOrderSign[] Returns an array of FixedOrderSign objects
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
    public function findOneBySomeField($value): ?FixedOrderSign
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
