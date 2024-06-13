<?php

namespace App\Repository;

use App\Entity\Representante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Representante>
 *
 * @method Representante|null find($id, $lockMode = null, $lockVersion = null)
 * @method Representante|null findOneBy(array $criteria, array $orderBy = null)
 * @method Representante[]    findAll()
 * @method Representante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepresentanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Representante::class);
    }

    /**
    * @return Representante[] Devuelve un array del objeto Representante.
    */
    public function findAll(): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    //    /**
    //     * @return Representante[] Returns an array of Representante objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Representante
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
