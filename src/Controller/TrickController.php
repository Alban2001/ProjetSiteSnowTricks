<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Illustration;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Form\TrickUpdateType;
use App\Service\TrickServiceInterface;
use App\Service\CommentServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use Symfony\Component\HttpFoundation\Request;

#[Route("/trick")]
class TrickController extends AbstractController
{
    public function __construct(private readonly TrickServiceInterface $trickService, private readonly CommentServiceInterface $commentService)
    {
    }

    // Affichage du trick avec ses informations en détails
    #[Route(path: "/display/{slug}/{page<\d+>?1}", name: "trick_display", requirements: ['page' => '\d+'], methods: ["GET", "POST"])]
    /**
     * Création d'un trick
     *
     * @param Trick $trick
     * @param Request $request
     * @param $page
     *
     * @return Response
     */
    public function display(#[MapEntity(expr: 'repository.findOneBySlug(slug)')] Trick $trick, Request $request, $page): Response
    {
        $comment = new Commentaire();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        // Traitement des commentaires pour un trick
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            // Ajout d'un commentaire pour un trick
            $this->commentService->add($comment, $trick, $user);

            return $this->redirectToRoute('trick_display', [
                "slug" => $trick->getSlug(),
                'page' => $page
            ]);
        }

        // Nombre de commentaires par page
        $number = 10;
        $trick->setIllustrationPrincipale();

        return $this->render("trick/display.html.twig", [
            'trick' => $trick,
            'formComment' => $form,
            'page' => $page,
            'number' => $number,
            // Affichage de tout les commentaires d'un trick
            'comments' => $this->commentService->displayAllCommentsBySlug($trick->getSlug(), $page, $number),
        ]);
    }

    #[Route(path: "/create", name: "trick_create", methods: ["GET", "POST"])]
    #[IsGranted('ROLE_USER', statusCode: 403)]
    /**
     * Création d'un trick
     *
     * @param Request $request
     *
     * @return Response
     */
    public function create(Request $request): Response
    {
        $trick = new Trick();
        $number = 3;
        for ($i = 0; $i < $number; $i++) {
            $trick->addIllustration(new Illustration());
            $trick->addVideo(new Video());
        }

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        // Traitement de la création d'un nouveau trick
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            // Ajout d'un trick
            $this->trickService->create($trick, $user);

            return $this->redirectToRoute('home');
        }

        return $this->render("trick/create.html.twig", [
            'form' => $form
        ]);
    }

    #[Route(path: "/update/{slug}", name: "trick_update", methods: ["GET", "POST"])]
    #[IsGranted('ROLE_USER', statusCode: 403)]
    /**
     * Mise à jour du trick
     *
     * @param Trick $trick
     * @param Request $request
     *
     * @return Response
     */
    public function update(#[MapEntity(expr: 'repository.findOneBySlug(slug)')] Trick $trick, Request $request): Response
    {
        $form = $this->createForm(TrickType::class, $trick, ['update' => true, 'submitLabel' => 'Mettre à jour']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            //Mise à jour d'un trick
            $this->trickService->update($trick, $request, $user);

            return $this->redirectToRoute('trick_update', [
                "slug" => $trick->getSlug()
            ]);
        }

        $trick->setIllustrationPrincipale();
        return $this->render("trick/update.html.twig", [
            'trick' => $trick,
            'form' => $form
        ]);
    }

    #[Route(path: "/delete/{slug}", name: "trick_delete", methods: ["GET"])]
    #[IsGranted('ROLE_USER', statusCode: 403)]
    /**
     * Suppression du trick
     *
     * @param #[MapEntity(expr: $trick
     *
     * @return Response
     */
    public function delete(#[MapEntity(expr: 'repository.findOneBySlug(slug)')] Trick $trick): Response
    {
        // Suppresion d'un trick
        $this->trickService->delete($trick);

        return $this->redirectToRoute('home');
    }

}