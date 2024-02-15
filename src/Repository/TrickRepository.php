<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @extends ServiceEntityRepository<Trick>
 *
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);
    }
    public function findAll(): array
    {
        return $this->createQueryBuilder('t')
            //->select('t, i, c, uc')
            ->select('t, i, u')
            ->join('t.illustrations', 'i')
            // ->join('t.commentaires', 'c')
            ->leftJoin('t.utilisateur', 'u')
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneBySlug(string $slug, int $page = 1): ?Trick
    {
        // $totalComments = 20; // résultat requête : nombre commentaires par trick
        $firstResult = 0;
        $totalResults = 5 * $page;
        // if ($totalResults > $totalComments) {
        //     throw new NotFoundHttpException();
        // }
        return $this->createQueryBuilder('t')
            ->select('t, i, u, v, c, g')
            ->leftJoin('t.illustrations', 'i')
            ->leftJoin('t.videos', 'v')
            ->leftJoin('t.utilisateur', 'u')
            ->leftJoin('t.commentaires', 'c')
            ->leftJoin('t.groupe', 'g')
            ->andWhere('t.slug = :slug')
            ->setParameter('slug', $slug)
            ->orderBy('t.id', 'ASC')
            ->setFirstResult($firstResult)
            ->setMaxResults($totalResults)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function countCommentsTrick(string $slug): int
    {
        return $this->createQueryBuilder('t')
            ->select('count(c.id)')
            ->leftJoin('t.commentaires', 'c')
            ->andWhere('t.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    //    /**
//     * @return Trick[] Returns an array of Trick objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    //    public function findOneBySomeField($value): ?Trick
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
