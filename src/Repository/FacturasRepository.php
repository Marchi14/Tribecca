<?php

namespace App\Repository;

use App\Entity\Facturas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Facturas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facturas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facturas[]    findAll()
 * @method Facturas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facturas::class);
    }

    public function FacturasCompletasporUsuario($user){
        $entityManager = $this->getEntityManager();

        return $query = $entityManager->createQuery(
            'SELECT cit.fecha,serv.nombre,serv.precio
            FROM App\Entity\Facturas fac
            JOIN fac.detalles dfac
            JOIN dfac.servicio serv
            JOIN fac.citas cit
            WHERE cit.user = :user'
        )->setParameter('user', $user);
    }

    // /**
    //  * @return Facturas[] Returns an array of Facturas objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Facturas
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
