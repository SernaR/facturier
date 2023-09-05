<?php

namespace App\Repository;

use App\Entity\Avoir;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Avoir|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avoir|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avoir[]    findAll()
 * @method Avoir[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvoirRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avoir::class);
    }

    public function findDebitCount(): int
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a.numero)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
