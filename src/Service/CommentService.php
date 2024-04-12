<?php

namespace App\Service;

use App\Entity\Commentaire;
use App\Entity\Trick;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;

class CommentService implements CommentServiceInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    // Selection et affichage de tous les commentaires pour un trick
    public function displayAllCommentsBySlug(string $slug, int $page, int $number)
    {
        $repository = $this->entityManager->getRepository(Commentaire::class);

        return $repository->displayAllCommentsBySlug($slug, $page, $number);
    }

    // Création d'un commentaire pour un trick
    public function add(Commentaire $comment, Trick $trick, Utilisateur $user)
    {
        $comment->setDateCreation(new \DateTime('now'));
        $comment->setTrick($trick);
        $comment->setUtilisateur($user);

        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }

    // Récupération du nombre de commentaires pour un trick
    public function countCommentsBySlug(string $slug, int $page): int
    {
        $repository = $this->entityManager->getRepository(Commentaire::class);

        return count($repository->displayAllCommentsBySlug($slug, $page));
    }
}