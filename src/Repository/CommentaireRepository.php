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

    // Affichage de tous les commentaires pour un trick (5 commentaires par trick)
    public function displayAllCommentsBySlug(string $slug, int $page = 1, int $number = 5): array
    {
        $firstResult = 0;   // Premier résultat
        $totalResults = $number * $page;    // Dernier résultat pour la page concernée

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
}
