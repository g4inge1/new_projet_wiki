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

//    /**
//     * @return ActuelleFiche[] Returns an array of ActuelleFiche objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ActuelleFiche
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
