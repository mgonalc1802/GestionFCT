<?php

namespace App\Repository;

use App\Entity\ProgramaFormativo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProgramaFormativo>
 *
 * @method ProgramaFormativo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgramaFormativo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgramaFormativo[]    findAll()
 * @method ProgramaFormativo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramaFormativoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgramaFormativo::class);
    }

    //    /**
    //     * @return ProgramaFormativo[] Returns an array of ProgramaFormativo objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ProgramaFormativo
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
