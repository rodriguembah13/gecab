<?php

namespace App\Repository;

use App\Entity\Consultation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @method Consultation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultation[]    findAll()
 * @method Consultation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultation::class);
    }
    /**
     * @return Consultation[] Returns an array of Depense objects
     */
    public function findByMultiparam($tenant, $datedebut, $datefin)
    {
        $day= new \DateTime('now');
        $dayAfter7=$day->sub(new \DateInterval('P07D'));
        $qb = $this->createQueryBuilder('d');
        if ($tenant != null) {
            $qb->andWhere('d.tenant = :type')
                ->setParameter('type', $tenant);
        }
        if ($datedebut != null) {
            $db=DateTime::getDateTime($datedebut);
            $end=DateTime::getDateTime($datefin);
            $qb->andWhere('d.createdAt BETWEEN :begin AND :end')
                ->setParameter('begin', $db)
                ->setParameter('end', $end);
        }
        $qb->orderBy('d.createdAt', 'DESC');

        return $qb->getQuery()->getResult();

    }
     /**
      * @return Consultation[] Returns an array of Consultation objects
      */

    public function findByExampleField(\DateTime $value)
    {
        $begin=new \DateTime('now');
        $end=$value->add(new \DateInterval('P1D'));
        return $this->createQueryBuilder('c')
            ->andWhere('c.createdAt BETWEEN :begin AND :end')
            ->setParameter('begin', $begin)
            ->setParameter('end',$end )
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Consultation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
