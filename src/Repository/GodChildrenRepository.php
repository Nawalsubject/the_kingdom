<?php

namespace App\Repository;

use App\Entity\GodChildren;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GodChildren|null find($id, $lockMode = null, $lockVersion = null)
 * @method GodChildren|null findOneBy(array $criteria, array $orderBy = null)
 * @method GodChildren[]    findAll()
 * @method GodChildren[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GodChildrenRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GodChildren::class);
    }

    // /**
    //  * @return GodChildren[] Returns an array of GodChildren objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GodChildren
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
