<?php

namespace App\Repository;

use App\Entity\Rendezvous;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rendezvous>
 *
 * @method Rendezvous|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rendezvous|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rendezvous[]    findAll()
 * @method Rendezvous[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RendezvousRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rendezvous::class);
    }

//    /**
//     * @return Rendezvous[] Returns an array of Rendezvous objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Rendezvous
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findRendezvousSansRapport()
{
    return $this->createQueryBuilder('r')
        ->leftJoin('r.rapport', 'rapport')
        ->where('rapport.id IS NULL OR r.rapport IS NULL')
        ->getQuery()
        ->getResult();
}

public function searchByCriteria(array $criteria): array
    {
        $queryBuilder = $this->createQueryBuilder('r');

        if (isset($criteria['fullname'])) {
            $queryBuilder
                ->andWhere('r.fullname LIKE :fullname')
                ->setParameter('fullname', '%' . $criteria['fullname'] . '%');
        }

        if (isset($criteria['date'])) {
            $queryBuilder
                ->andWhere('r.date = :date')
                ->setParameter('date', $criteria['date']);
        }
        if (isset($criteria['medecin'])) {
            $queryBuilder
                ->andWhere('r.medecin = :medecin')
                ->setParameter('medecin', $criteria['medecin']);
        }

        // Ajoutez autant de conditions que nécessaire

        return $queryBuilder->getQuery()->getResult();
    }
}
