<?php

namespace App\Repository;

use App\Entity\FamiliaProfesional;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FamiliaProfesional>
 *
 * @method FamiliaProfesional|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamiliaProfesional|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamiliaProfesional[]    findAll()
 * @method FamiliaProfesional[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamiliaProfesionalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamiliaProfesional::class);
    }

    //    /**
    //     * @return FamiliaProfesional[] Returns an array of FamiliaProfesional objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?FamiliaProfesional
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
