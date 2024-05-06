<?php

namespace App\Repository;

use App\Entity\CursoEscolar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CursoEscolar>
 *
 * @method CursoEscolar|null find($id, $lockMode = null, $lockVersion = null)
 * @method CursoEscolar|null findOneBy(array $criteria, array $orderBy = null)
 * @method CursoEscolar[]    findAll()
 * @method CursoEscolar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CursoEscolarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CursoEscolar::class);
    }

    //    /**
    //     * @return CursoEscolar[] Returns an array of CursoEscolar objects
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

    //    public function findOneBySomeField($value): ?CursoEscolar
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
