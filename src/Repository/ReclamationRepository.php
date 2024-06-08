<?php

namespace App\Repository;

use App\Entity\Reclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reclamation>
 *
 * @method Reclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclamation[]    findAll()
 * @method Reclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamation::class);
    }

    public function countTotalReclamations(): int
    {
        return $this->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countReclamationsByCategory(): array
{
    $categories = [
        'Technique' => 0,
        'Design/UI' => 0,
        'Contenu' => 0,
        'Sécurité' => 0,
        'Communication/Support' => 0,
    ];

    $result = $this->createQueryBuilder('r')
        ->select('r.categorie, COUNT(r.id) as reclamationsCount')
        ->groupBy('r.categorie')
        ->getQuery()
        ->getResult();

    foreach ($result as $row) {
        $categories[$row['categorie']] = (int) $row['reclamationsCount'];
    }

    return $categories;
}
public function searchAdvanced($criteria)
{
    $queryBuilder = $this->createQueryBuilder('r');

    if (!empty($criteria['title'])) {
        $queryBuilder->andWhere('r.title LIKE :title')
            ->setParameter('title', '%' . $criteria['title'] . '%');
    }

    if (!empty($criteria['category'])) {
        $queryBuilder->andWhere('r.category = :category')
            ->setParameter('category', $criteria['category']);
    }

    // Ajoutez d'autres conditions selon vos critères de recherche avancée

    return $queryBuilder->getQuery()->getResult();
}
public function findByNom($nom)
{
    return $this->createQueryBuilder('r')
        ->andWhere('r.nom = :nom')
        ->setParameter('nom', $nom)
        ->getQuery()
        ->getResult();
}


//    /**
//     * @return Reclamation[] Returns an array of Reclamation objects
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

//    public function findOneBySomeField($value): ?Reclamation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
