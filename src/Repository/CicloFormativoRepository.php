<?php

namespace App\Repository;

use App\Entity\CicloFormativo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CicloFormativo>
 *
 * @method CicloFormativo|null find($id, $lockMode = null, $lockVersion = null)
 * @method CicloFormativo|null findOneBy(array $criteria, array $orderBy = null)
 * @method CicloFormativo[]    findAll()
 * @method CicloFormativo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CicloFormativoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CicloFormativo::class);
    }

    //    /**
    //     * @return CicloFormativo[] Returns an array of CicloFormativo objects
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

    //    public function findOneBySomeField($value): ?CicloFormativo
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
