<?php

namespace App\Repository;

use App\Entity\Etablissements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Etablissements>
 *
 * @method Etablissements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etablissements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etablissements[]    findAll()
 * @method Etablissements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtablissementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etablissements::class);
    }

    public function findFavoris(): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.favoris = :favoris')
            ->setParameter('favoris', true)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Etablissements[] Returns an array of Etablissements objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Etablissements
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
