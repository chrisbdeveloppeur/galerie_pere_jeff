<?php

namespace App\Repository;

use App\Entity\TextMenuBurger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TextMenuBurger|null find($id, $lockMode = null, $lockVersion = null)
 * @method TextMenuBurger|null findOneBy(array $criteria, array $orderBy = null)
 * @method TextMenuBurger[]    findAll()
 * @method TextMenuBurger[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TextMenuBurgerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TextMenuBurger::class);
    }

    // /**
    //  * @return TextMenuBurger[] Returns an array of TextMenuBurger objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TextMenuBurger
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
