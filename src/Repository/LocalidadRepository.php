<?php

namespace App\Repository;

use App\Entity\Localidad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Localidad>
 *
 * @method Localidad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Localidad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Localidad[]    findAll()
 * @method Localidad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalidadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Localidad::class);
    }

       /**
        * @return Localidad[] Devuelve un array del objeto Localidad.
        */
       public function findAll(): array
       {
           return $this->createQueryBuilder('l')
               ->orderBy('l.id', 'ASC')
               ->getQuery()
               ->getResult()
           ;
       }

       /**
        * @return Localidad[] Devuelve un array de objetos del objeto Localidad filtrados por provincia
        */
       public function findByProvincia($provincia): ?array
       {
           return $this->createQueryBuilder('l')
                ->join('l.provi', 'p') // Unir la tabla Provincia con el alias 'p'
                ->andWhere('p.nombre LIKE :provi') // Filtrar por nombre de provincia
                ->setParameter('provi', $provincia)
                ->getQuery()
                ->getResult()
                ;
           ;
       }

       /**
        * @return Localidad Devuelve un objeto del tipo Localidad filtrados por un nombre.
        */
        public function findByNombre($nombre): ?Localidad
        {
            return $this->createQueryBuilder('l')
                 ->andWhere('l.nombre LIKE :val') // Buscar una localidad concreta
                 ->setParameter('val', $nombre)
                 ->getQuery()
                 ->getOneOrNullResult()
                 ;
            ;
        }

        // public function findOneBySomeField($value): ?Periodo
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
