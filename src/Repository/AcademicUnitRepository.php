<?php

namespace App\Repository;

use App\Entity\AcademicUnit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AcademicUnit|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcademicUnit|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcademicUnit[]    findAll()
 * @method AcademicUnit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcademicUnitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcademicUnit::class);
    }

    // /**
    //  * @return AcademicUnit[] Returns an array of AcademicUnit objects
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
    public function findOneBySomeField($value): ?AcademicUnit
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
