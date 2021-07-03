<?php

namespace App\Repository;

use App\Entity\Citas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Citas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Citas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Citas[]    findAll()
 * @method Citas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CitasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Citas::class);
    }

    public function CitasPendientesporUsuario($user){
        $entityManager = $this->getEntityManager();

        return $query = $entityManager->createQuery(
            'SELECT cit.id,cit.fecha,cit.hora,fac.importe_total
            FROM App\Entity\Citas cit
            JOIN cit.factura fac
            WHERE cit.user = :user AND cit.fecha >= CURRENT_DATE()'
        )->setParameter('user', $user);
    }

    // /**
    //  * @return Citas[] Returns an array of Citas objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Citas
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
