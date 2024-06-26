<?php

namespace App\Repository;

use App\Entity\Provincia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Provincia>
 *
 * @method Provincia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Provincia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Provincia[]    findAll()
 * @method Provincia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProvinciaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Provincia::class);
    }

       /**
        * @return Provincia[] Devuelve un array del objeto Provincia
        */
       public function findAll(): array
       {
           return $this->createQueryBuilder('p')
               ->orderBy('p.nombre', 'ASC')
               ->getQuery()
               ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?Provincia
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
