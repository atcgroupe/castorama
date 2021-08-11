<?php

namespace App\Repository;

use App\Entity\SignItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SignItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method SignItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method SignItem[]    findAll()
 * @method SignItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SignItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SignItem::class);
    }

    // /**
    //  * @return SignItem[] Returns an array of SignItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SignItem
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
