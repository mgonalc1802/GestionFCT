<?php

namespace App\Repository;

use App\Entity\CentroTrabajo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CentroTrabajo>
 *
 * @method CentroTrabajo|null find($id, $lockMode = null, $lockVersion = null)
 * @method CentroTrabajo|null findOneBy(array $criteria, array $orderBy = null)
 * @method CentroTrabajo[]    findAll()
 * @method CentroTrabajo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentroTrabajoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CentroTrabajo::class);
    }

    //    /**
    //     * @return CentroTrabajo[] Returns an array of CentroTrabajo objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CentroTrabajo
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
