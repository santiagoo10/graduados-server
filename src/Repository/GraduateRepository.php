<?php

namespace App\Repository;

use App\Entity\Graduate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Graduate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Graduate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Graduate[]    findAll()
 * @method Graduate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GraduateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Graduate::class);
    }

    // /**
    //  * @return Graduate[] Returns an array of Graduate objects
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
    public function findOneBySomeField($value): ?Graduate
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
