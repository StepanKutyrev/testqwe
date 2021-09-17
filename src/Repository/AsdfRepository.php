<?php

namespace App\Repository;

use App\Entity\Asdf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Asdf|null find($id, $lockMode = null, $lockVersion = null)
 * @method Asdf|null findOneBy(array $criteria, array $orderBy = null)
 * @method Asdf[]    findAll()
 * @method Asdf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AsdfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Asdf::class);
    }

    // /**
    //  * @return Asdf[] Returns an array of Asdf objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Asdf
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
