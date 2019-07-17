<?php

namespace App\Repository;

use App\Entity\FileCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FileCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileCategory[]    findAll()
 * @method FileCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FileCategory::class);
    }

    // /**
    //  * @return FileCategory[] Returns an array of FileCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FileCategory
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
