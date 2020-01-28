<?php

namespace App\Repository;

use App\Entity\LigneAvoir;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LigneAvoir|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneAvoir|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneAvoir[]    findAll()
 * @method LigneAvoir[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneAvoirRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneAvoir::class);
    }

    // /**
    //  * @return LigneAvoir[] Returns an array of LigneAvoir objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LigneAvoir
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
