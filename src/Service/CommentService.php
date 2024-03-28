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

    public function displayAllCommentsBySlug(string $slug, int $page, int $number)
    {
        $repository = $this->entityManager->getRepository(Commentaire::class);

        // Selection et affichage de tous les commentaires
        $comments = $repository->displayAllCommentsBySlug($slug, $page, $number);

        return $comments;
    }

    //Création d'un commentaire pour un trick précis
    public function add(Commentaire $comment, Trick $trick, Utilisateur $user)
    {
        $comment->setDateCreation(new \DateTime('now'));
        $comment->setTrick($trick);
        $comment->setUtilisateur($user);

        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }

    public function countCommentsBySlug(string $slug, int $page): int
    {
        $repository = $this->entityManager->getRepository(Commentaire::class);

        // Selection et affichage des détails complets d'un trick
        return count($repository->displayAllCommentsBySlug($slug, $page));
    }
}