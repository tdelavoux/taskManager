<?php

namespace App\Repository;

use App\Entity\Priorite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Priorite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Priorite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Priorite[]    findAll()
 * @method Priorite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrioriteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Priorite::class);
    }

    // /**
    //  * @return Priorite[] Returns an array of Priorite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Priorite
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
