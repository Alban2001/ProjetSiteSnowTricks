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

    //Création d'un commentaire pour un trick précis
    public function add(Commentaire $comment, Trick $trick, Utilisateur $user)
    {
        $comment->setDateCreation(new \DateTime('now'));
        $comment->setTrick($trick);
        $comment->setUtilisateur($user);

        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }
}