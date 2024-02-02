<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Service\TrickServiceInterface;
use App\Service\CommentServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Symfony\Component\HttpFoundation\Request;

class TrickController extends AbstractController
{
    public function __construct(private readonly TrickServiceInterface $trickService, private readonly CommentServiceInterface $commentService)
    {
    }

    #[Route(path: "/display/{slug}?page={page}", name: "trick_display", requirements: ['page' => '\d+'], methods: ["GET", "POST"])]
    public function display(#[MapEntity(expr: 'repository.findOneBySlug(slug, page)')] Trick $trick, Request $request, $page): Response
    {
        $trick->setIllustrationPrincipale();
        $comment = new Commentaire();
        $countComments = $this->trickService->countCommentsTrick($trick->getSlug());

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $trick->getUtilisateur(); //@ToDo : $this->getUser();
            $this->commentService->add($comment, $trick, $user);
            return $this->redirectToRoute('trick_display', [
                "slug" => $trick->getSlug(),
                'page' => $page
            ]);
        }

        // Selection et affichage du trick
        return $this->render("trick/display.html.twig", [
            'trick' => $trick,
            'formComment' => $form,
            'page' => $page,
            'countComments' => $countComments
        ]);
    }

}