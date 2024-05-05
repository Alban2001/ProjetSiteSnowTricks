<?php

namespace App\Controller;

use App\Service\TrickServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(private readonly TrickServiceInterface $trickService)
    {
    }

    #[Route(path: "/{page<\d+>?1}", name: "home", methods: ["GET"])]
    /**
     * Page d'accueil : affichage de l'ensemble des tricks
     *
     * @return Response
     */
    public function index($page): Response
    {
        // Nombre de tricks par page
        $number = 10;

        // Selection et affichage de tous les tricks
        $tricks = $this->trickService->findAll($page, $number);
        $nbrTricks = $this->trickService->countTricks();

        return $this->render("home.html.twig", [
            'tricks' => $tricks,
            'page' => $page,
            'number' => $number,
            'nbrTricks' => $nbrTricks
        ]);
    }

}