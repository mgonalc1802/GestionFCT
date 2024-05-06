<?php

namespace App\Repository;

use App\Entity\CriterioEvaluacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CriterioEvaluacion>
 *
 * @method CriterioEvaluacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method CriterioEvaluacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method CriterioEvaluacion[]    findAll()
 * @method CriterioEvaluacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CriterioEvaluacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CriterioEvaluacion::class);
    }

    //    /**
    //     * @return CriterioEvaluacion[] Returns an array of CriterioEvaluacion objects
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

    //    public function findOneBySomeField($value): ?CriterioEvaluacion
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
