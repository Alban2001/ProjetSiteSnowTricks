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

    // Affichage de tous les tricks
    public function findAll(): array
    {
        return $this->createQueryBuilder('t')
            ->select('t, i, u')
            ->join('t.illustrations', 'i')
            ->leftJoin('t.utilisateur', 'u')
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // Affichage de l'ensemble des informations d'un trick (=en fonction du slug)
    public function findOneBySlug(string $slug, int $page = 1): ?Trick
    {
        return $this->createQueryBuilder('t')
            ->select('t, i, u, v, g')
            ->join('t.illustrations', 'i')
            ->join('t.videos', 'v')
            ->leftJoin('t.utilisateur', 'u')
            ->leftJoin('t.groupe', 'g')
            ->andWhere('t.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // Affichage du nombre de commentaires total pour un trick
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
}
