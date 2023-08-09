<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Vetements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vetements>
 *
 * @method Vetements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vetements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vetements[]    findAll()
 * @method Vetements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VetementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vetements::class);
    }

    /**
     * @return Vetements[]
     * retourne les derniers vetements rajoutés
     */
    public function findLatest(): array
    {
        return $this->createQueryBuilder('v')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Query
     * retourne tous les vetements
     */
    public function findAllQuery(SearchData $search): array
    {
        $query = $this
            ->createQueryBuilder('v');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('v.titre LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->categorie)) {
            $query = $query
                ->andWhere($query->expr()->in('v.categorie', ':categorie'))
                ->setParameter('categorie', $search->categorie);
        }

        if (!empty($search->sex)) {
            $query = $query
                ->andWhere($query->expr()->in('v.sex', ':sex'))
                ->setParameter('sex', $search->sex);
        }

        if (!empty($search->taille)) {
            $query = $query
                ->andWhere($query->expr()->in('v.taille', ':taille'))
                ->setParameter('taille', $search->taille);
        }

        if (!empty($search->prixMin)) {
            $query = $query
                ->andWhere('v.prix >= :prixMin')
                ->setParameter('prixMin', $search->prixMin);
        }

        if (!empty($search->prixMax)) {
            $query = $query
                ->andWhere('v.prix <= :prixMax')
                ->setParameter('prixMax', $search->prixMax);
        }

        return $query->getQuery()->getResult();
        
    }

//    /**
//     * @return Vetements[] Returns an array of Vetements objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Vetements
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
