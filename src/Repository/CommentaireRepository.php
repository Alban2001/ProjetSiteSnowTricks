<?php

namespace App\Repository;

use App\Entity\Commentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commentaire>
 *
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    public function displayAllCommentsBySlug(string $slug, int $page = 1, int $number = 5): array
    {
        // $totalComments = 20; // résultat requête : nombre commentaires par trick
        $firstResult = 0;
        $totalResults = $number * $page;
        // if ($totalResults > $totalComments) {
        //     throw new NotFoundHttpException();
        // }
        return $this->createQueryBuilder('c')
            ->select('c, u')
            ->join('c.trick', 't')
            ->leftJoin('c.utilisateur', 'u')
            ->andWhere('t.slug = :slug')
            ->setParameter('slug', $slug)
            ->setFirstResult($firstResult)
            ->setMaxResults($totalResults)
            ->getQuery()
            ->getResult()
        ;
    }

    //    /**
//     * @return Commentaire[] Returns an array of Commentaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    //    public function findOneBySomeField($value): ?Commentaire
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
