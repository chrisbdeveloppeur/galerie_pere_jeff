<?php

namespace App\Repository;

use App\Entity\YearDirectory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method YearDirectory|null find($id, $lockMode = null, $lockVersion = null)
 * @method YearDirectory|null findOneBy(array $criteria, array $orderBy = null)
 * @method YearDirectory[]    findAll()
 * @method YearDirectory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YearDirectoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YearDirectory::class);
    }

    // /**
    //  * @return YearDirectory[] Returns an array of YearDirectory objects
    //  */

    public function classByYear()
    {
        return $this->createQueryBuilder('y')
//            ->andWhere('y.exampleField = :val')
//            ->setParameter('val', $value)
            ->orderBy('y.year', 'DESC')
//            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByYear($value)
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.year = :val')
            ->setParameter('val', $value)
            ->orderBy('y.year', 'DESC')
//            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?YearDirectory
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
