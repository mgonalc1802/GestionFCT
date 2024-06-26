<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
    

       /**
        * @return User[] Returns an array of User objects
        */
       public function findAlumnos(): array
       {
           return $this->createQueryBuilder('u')
               ->andWhere('u.roles LIKE :val')
               ->setParameter('val', '%"ROLE_ALUMNO"%' )
               ->getQuery()
               ->getResult()
           ;
       }

       /**
        * @return User[] Returns an array of User objects
        */
        public function findProfesores(): array
        {
            return $this->createQueryBuilder('u')
                ->andWhere('u.roles LIKE :val')
                ->setParameter('val', '%"ROLE_PROFESOR"%' )
                ->getQuery()
                ->getResult()
            ;
        }

       /**
        * @return User Devuelve un usuario que es buscado por id
        */
        public function findById($id): ?User
        {
            return $this->createQueryBuilder('r')
                        ->andWhere('r.id = :val')
                        ->setParameter('val', $id)
                        ->getQuery()
                        ->getOneOrNullResult()
            ;
        }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
