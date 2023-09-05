<?php

namespace App\Repository;

use App\Entity\Facture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Facture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facture[]    findAll()
 * @method Facture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facture::class);
    }

    public function findInvoiceCount(): int
    {
        return $this->createQueryBuilder('f')
            ->select('COUNT(f.numero)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findMaintenanceContracts(): array
    {
        return $this->createQueryBuilder('f')
            ->join('f.ligneFacture','l')
            ->join('l.prestation', 'p')
            ->where('p.libelle like :lib')
            ->andWhere('f.finPrestation > :datecourant')
            ->setParameter('lib', '%Maintenance%')
            ->setParameter('datecourant', new \Datetime(date('d-m-Y')))
            ->orderBy('f.finPrestation', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
