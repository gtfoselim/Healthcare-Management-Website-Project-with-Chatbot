<?php

namespace App\Repository;

use App\Entity\Reservationservice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservationservice>
 *
 * @method Reservationservice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservationservice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservationservice[]    findAll()
 * @method Reservationservice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationserviceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservationservice::class);
    }

//    /**
//     * @return Reservationservice[] Returns an array of Reservationservice objects
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

//    public function findOneBySomeField($value): ?Reservationservice
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
