<?php

namespace App\Repository;

use App\Entity\ActuelleFiche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActuelleFiche>
 *
 * @method ActuelleFiche|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActuelleFiche|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActuelleFiche[]    findAll()
 * @method ActuelleFiche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActuelleFicheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActuelleFiche::class);
    }

    public function findByFilters($search, $startDate, $endDate, $category, $sortField = 'dateCreation', $sortOrder = 'DESC')
{
    $qb = $this->createQueryBuilder('a');

    // Filtrage par titre
    if ($search) {
        $qb->andWhere('a.titre LIKE :search')
           ->setParameter('search', '%' . $search . '%');
    }

    // Filtrage par date de début
    if ($startDate) {
        $qb->andWhere('a.dateCreation >= :startDate')
           ->setParameter('startDate', new \DateTime($startDate . ' 00:00:00'));
    }

    // Filtrage par date de fin
    if ($endDate) {
        $qb->andWhere('a.dateCreation <= :endDate')
           ->setParameter('endDate', new \DateTime($endDate . ' 23:59:59'));
    }

    // Filtrage par catégorie
    if ($category) {
        $qb->andWhere('a.idCategories = :idCategories')
           ->setParameter('idCategories', $category);
    }

    $qb->orderBy('a.' . $sortField, $sortOrder);

    return $qb->getQuery()->getResult();
}

//    public function findByCategorieID($categorie): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.idFiche = :ficheId')
//            ->setParameter('ficheId', $categorie)
//            ->orderBy('c.id', 'ASC')
//            ->getQuery()
//            ->getResult();
//    }

}