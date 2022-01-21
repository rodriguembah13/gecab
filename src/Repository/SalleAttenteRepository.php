<?php

namespace App\Repository;

use App\Entity\SalleAttente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SalleAttente|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalleAttente|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalleAttente[]    findAll()
 * @method SalleAttente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalleAttenteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalleAttente::class);
    }
    /**
     * @return SalleAttente[] Returns an array of SalleAttente objects
     */
    public function findBystaut()
    {
        return $this->createQueryBuilder('da')
            ->where('da.status IN (:ids)')
            ->setParameter('ids', ['attente', 'encours'])
            ->orderBy('da.createdAt', 'DESC')
            ->setMaxResults(1000)
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return SalleAttente[] Returns an array of SalleAttente objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SalleAttente
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
