<?php

namespace App\Repository;

use App\Entity\PersonaContacto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonaContacto>
 *
 * @method PersonaContacto|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonaContacto|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonaContacto[]    findAll()
 * @method PersonaContacto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonaContactoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonaContacto::class);
    }

    /**
     * Devuelve un objeto de tipo PersonaContacto
     */
    public function findById($id): ?PersonaContacto
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

//    /**
//     * @return PersonaContacto[] Returns an array of PersonaContacto objects
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

//    public function findOneBySomeField($value): ?PersonaContacto
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
