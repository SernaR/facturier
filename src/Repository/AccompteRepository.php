<?php

namespace App\Repository;

use App\Entity\Accompte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function findAdvanceCount(): int
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a.numero)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
