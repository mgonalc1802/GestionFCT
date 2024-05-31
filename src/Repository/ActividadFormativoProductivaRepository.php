<?php

namespace App\Repository;

use App\Entity\ActividadFormativoProductiva;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActividadFormativoProductiva>
 *
 * @method ActividadFormativoProductiva|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActividadFormativoProductiva|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActividadFormativoProductiva[]    findAll()
 * @method ActividadFormativoProductiva[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActividadFormativoProductivaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActividadFormativoProductiva::class);
    }

    /**
    * @return ActividadFormativoProductivaRepository[] Devuelve un array de objetos tipo ActividadFormativoProductiva
    */
    public function findAll(): array
    {
        return $this->createQueryBuilder('a')
            ->getQuery()
            ->getResult()
        ;
    }

    //    /**
    //     * @return ActividadFormativoProductiva[] Returns an array of ActividadFormativoProductiva objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ActividadFormativoProductiva
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
