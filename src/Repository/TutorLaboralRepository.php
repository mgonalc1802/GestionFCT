<?php

namespace App\Repository;

use App\Entity\TutorLaboral;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TutorLaboral>
 *
 * @method TutorLaboral|null find($id, $lockMode = null, $lockVersion = null)
 * @method TutorLaboral|null findOneBy(array $criteria, array $orderBy = null)
 * @method TutorLaboral[]    findAll()
 * @method TutorLaboral[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TutorLaboralRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TutorLaboral::class);
    }

    //    /**
    //     * @return TutorLaboral[] Returns an array of TutorLaboral objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TutorLaboral
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
