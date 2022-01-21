<?php

namespace App\Repository;

use App\Entity\AntecedantPatient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AntecedantPatient|null find($id, $lockMode = null, $lockVersion = null)
 * @method AntecedantPatient|null findOneBy(array $criteria, array $orderBy = null)
 * @method AntecedantPatient[]    findAll()
 * @method AntecedantPatient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AntecedantPatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AntecedantPatient::class);
    }

    // /**
    //  * @return AntecedantPatient[] Returns an array of AntecedantPatient objects
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
    public function findOneBySomeField($value): ?AntecedantPatient
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
