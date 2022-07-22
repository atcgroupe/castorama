<?php

namespace App\Repository;

use App\Entity\FixedSign;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FixedSign|null find($id, $lockMode = null, $lockVersion = null)
 * @method FixedSign|null findOneBy(array $criteria, array $orderBy = null)
 * @method FixedSign[]    findAll()
 * @method FixedSign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FixedSignRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FixedSign::class);
    }

    // /**
    //  * @return FixedSign[] Returns an array of FixedSign objects
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
    public function findOneBySomeField($value): ?FixedSign
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
