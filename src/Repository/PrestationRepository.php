<?php

namespace App\Repository;

use App\Entity\Prestation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prestation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prestation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prestation[]    findAll()
 * @method Prestation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prestation::class);
    }

    public function findService($libelle): array
    {
        return $this->createQueryBuilder('p')
        ->where('p.libelle LIKE :libelle')
        ->andWhere('p.dateDeFin is null')
        ->setParameter('libelle', '%'.$libelle.'%')
        ->orderBy('p.libelle', 'ASC')
        ->getQuery()
        ->getResult();
    }

}
