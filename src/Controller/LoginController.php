<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    /**
     * Page de connexion
     *
     * @param AuthenticationUtils $authenticationUtils [explicite description]
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupère les erreurs login s'il y en a
        $error = $authenticationUtils->getLastAuthenticationError();

        // Récupère le dernier utilisateur connecté
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    /**
     * Page de déconnexion
     *
     * @return Response
     */
    public function logout(): Response
    {
        return $this->render('security/login.html.twig');
    }
}
