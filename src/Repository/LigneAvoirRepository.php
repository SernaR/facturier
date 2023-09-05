<?php

namespace App\Repository;

use App\Entity\LigneAvoir;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
}
