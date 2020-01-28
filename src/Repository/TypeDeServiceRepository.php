<?php

namespace App\Repository;

use App\Entity\TypeDeService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypeDeService|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeDeService|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeDeService[]    findAll()
 * @method TypeDeService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeDeServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeDeService::class);
    }

    // /**
    //  * @return TypeDeService[] Returns an array of TypeDeService objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeDeService
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
