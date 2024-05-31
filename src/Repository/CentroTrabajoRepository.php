<?php

namespace App\Repository;

use App\Entity\CentroTrabajo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CentroTrabajo>
 *
 * @method CentroTrabajo|null find($id, $lockMode = null, $lockVersion = null)
 * @method CentroTrabajo|null findOneBy(array $criteria, array $orderBy = null)
 * @method CentroTrabajo[]    findAll()
 * @method CentroTrabajo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentroTrabajoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CentroTrabajo::class);
    }

    /**
    * @return CentroTrabajo[] Devuelve un array de objetos tipo CentroTrabajo
    */
    public function findAll(): array
    {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByEmpresa($empresa): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.empresa = :val')
            ->setParameter('val', $empresa)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
