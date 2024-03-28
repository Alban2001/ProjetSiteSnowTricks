<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Illustration;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Service\TrickServiceInterface;
use App\Service\CommentServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\HttpFoundation\Request;

#[Route("/trick")]
class TrickController extends AbstractController
{
    public function __construct(private readonly TrickServiceInterface $trickService, private readonly CommentServiceInterface $commentService)
    {
    }

    #[Route(path: "/display/{slug}?page={page}", name: "trick_display", requirements: ['page' => '\d+'], methods: ["GET", "POST"])]
    public function display(#[MapEntity(expr: 'repository.findOneBySlug(slug, page)')] Trick $trick, Request $request, $page): Response
    {
        $number = 5;
        $trick->setIllustrationPrincipale();
        $comment = new Commentaire();
        //$countComments = $this->trickService->countCommentsTrick($trick->getSlug());
        //$countComments = count($trick->getCommentaires());
        //$countCommentsBySlug = $this->commentService->countCommentsBySlug($trick->getSlug(), $page);
        // $countCommentsBySlug = $this->commentService->countCommentsBySlug($trick->getSlug(), $page);

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
        //$comments = $this->commentService->displayAllCommentsBySlug($trick->getSlug(), $page);
        return $this->render("trick/display.html.twig", [
            'trick' => $trick,
            'formComment' => $form,
            'page' => $page,
            'number' => $number,
            // 'countComments' => $countComments,
            // 'countCommentsBySlug' => $countCommentsBySlug,
            'comments' => $this->commentService->displayAllCommentsBySlug($trick->getSlug(), $page, $number),
        ]);
    }

    #[Route(path: "/delete/{slug}", name: "trick_delete", methods: ["GET"])]
    public function delete(#[MapEntity(expr: 'repository.findOneBySlug(slug)')] Trick $trick): Response
    {
        $this->trickService->delete($trick);

        return $this->redirectToRoute('home');
    }
    #[Route(path: "/create", name: "trick_create", methods: ["GET", "POST"])]
    public function create(ValidatorInterface $validator, Request $request): Response
    {
        $trick = new Trick();
        $number = 3;
        for ($i = 0; $i < $number; $i++) {
            $trick->addIllustration(new Illustration());
            $trick->addVideo(new Video());
        }

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        $errors = $validator->validate($trick);
        if ($form->isSubmitted()) {
            if (count($errors) > 0) {
                return $this->render('trick/create.html.twig', [
                    'form' => $form,
                    'errors' => $errors,
                ]);
            } else {
                if ($form->isValid()) {
                    $this->trickService->create($trick);

                    return $this->redirectToRoute('home');
                }
            }
        }
        // Selection et affichage de tous les tricks
        return $this->render("trick/create.html.twig", [
            'form' => $form
        ]);
    }
}