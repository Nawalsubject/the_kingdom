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

    public function findAllWithoutUserGodchildren($userId)
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.buddy', 'buddy')
            ->where('u.buddy IS NULL OR u.buddy <> :user_id')
            ->andWhere('u.id <> :user_id')
            ->setParameter(':user_id', $userId)
            ->orderBy('u.firstname')
            ->addOrderBy('u.lastname')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return User[] Returns an array of Article objects
     */

    public function searchByName($name, $userId)
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.buddy', 'buddy')
            ->Where('u.firstname LIKE :name OR u.lastname LIKE :name')
            ->andWhere('u.buddy IS NULL OR u.buddy <> :user_id')
            ->andWhere('u.id <> :user_id')
            ->setParameter('name', "%$name%")
            ->setParameter('user_id', $userId)
            ->orderBy('u.firstname', 'ASC')
            ->addOrderBy('u.lastname', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
