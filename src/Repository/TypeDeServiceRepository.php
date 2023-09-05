<?php

namespace App\Repository;

use App\Entity\TypeDeService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

}
