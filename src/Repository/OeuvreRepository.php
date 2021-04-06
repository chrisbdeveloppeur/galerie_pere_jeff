<?php

namespace App\Repository;

use App\Entity\Oeuvre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Oeuvre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Oeuvre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Oeuvre[]    findAll()
 * @method Oeuvre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OeuvreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Oeuvre::class);
    }

    // /**
    //  * @return Oeuvre[] Returns an array of Oeuvre objects
    //  */


    public function groupedByAnnee()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.annee', 'DESC')
            ->groupBy('o.annee')
            ->getQuery()
            ->getResult()
            ;
    }

    public function classByAnnee()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.year_directory', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByGalery($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.year_directory = :val')
            ->setParameter('val', $value)
            ->orderBy('o.year', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }





}
