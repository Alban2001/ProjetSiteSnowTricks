<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Service\TrickServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(private readonly TrickServiceInterface $trickService)
    {
    }

    #[Route(path: "/", name: "home", methods: ["GET"])]
    public function index(): Response
    {
        // Selection et affichage de tous les tricks
        $tricks = $this->trickService->findAll();
        return $this->render("home.html.twig", [
            'tricks' => $tricks
        ]);
    }

}