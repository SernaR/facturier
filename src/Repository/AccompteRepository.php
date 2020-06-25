<?php

namespace App\Repository;

use App\Entity\Accompte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Accompte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Accompte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Accompte[]    findAll()
 * @method Accompte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccompteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accompte::class);
    }

    public function findAdvanceCount(){
        return $this->createQueryBuilder('a')
            ->select('COUNT(a.numero)')
            ->getQuery()
            ->getSingleScalarResult();
    } 

    // /**
    //  * @return Accompte[] Returns an array of Accompte objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Accompte
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
