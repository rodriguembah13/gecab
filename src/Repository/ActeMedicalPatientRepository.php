<?php

namespace App\Repository;

use App\Entity\ActeMedicalPatient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActeMedicalPatient|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActeMedicalPatient|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActeMedicalPatient[]    findAll()
 * @method ActeMedicalPatient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActeMedicalPatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActeMedicalPatient::class);
    }

    // /**
    //  * @return ActeMedicalPatient[] Returns an array of ActeMedicalPatient objects
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
    public function findOneBySomeField($value): ?ActeMedicalPatient
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
