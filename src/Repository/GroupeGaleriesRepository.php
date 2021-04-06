<?php

namespace App\Repository;

use App\Entity\GroupeGaleries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GroupeGaleries|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupeGaleries|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupeGaleries[]    findAll()
 * @method GroupeGaleries[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeGaleriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupeGaleries::class);
    }

    // /**
    //  * @return GroupeGaleries[] Returns an array of GroupeGaleries objects
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
    public function findOneBySomeField($value): ?GroupeGaleries
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
