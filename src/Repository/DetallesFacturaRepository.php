<?php

namespace App\Repository;

use App\Entity\DetallesFactura;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetallesFactura|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetallesFactura|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetallesFactura[]    findAll()
 * @method DetallesFactura[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetallesFacturaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetallesFactura::class);
    }

    // /**
    //  * @return DetallesFactura[] Returns an array of DetallesFactura objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetallesFactura
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
