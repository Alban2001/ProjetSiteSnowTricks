<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Service\TrickServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

class TrickController extends AbstractController
{
    public function __construct(private readonly TrickServiceInterface $trickService)
    {
    }

    #[Route(path: "/trick/{slug}", name: "trick_display", methods: ["GET", "POST"])]
    public function display(#[MapEntity(expr: 'repository.findOneBySlug(slug)')] Trick $trick): Response
    {
        $trick->setIllustrationPrincipale();
        $comment = new Commentaire();
        $formComment = $this->createForm(CommentType::class, $comment);

        // Selection et affichage de tous les tricks
        return $this->render("trick.html.twig", [
            'trick' => $trick,
            'formComment' => $formComment
        ]);
    }
}