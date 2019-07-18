<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[] Returns an array of Article objects
     */

    public function searchByName($name)
    {
        return $this->createQueryBuilder('u')
            ->Where('u.firstname LIKE :name')
            ->orWhere('u.lastname LIKE :name')
            ->setParameter('name', "%$name%")
            ->orderBy('u.firstname', 'ASC')
            ->addOrderBy('u.lastname', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
