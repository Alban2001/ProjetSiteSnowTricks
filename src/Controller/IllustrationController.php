<?php

namespace App\Controller;

use App\Entity\Illustration;
use App\Service\IllustrationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

#[Route("/illustration")]
class IllustrationController extends AbstractController
{
    public function __construct(private readonly IllustrationServiceInterface $illustrationService)
    {
    }

    #[Route('/delete/{id}', name: 'delete_illustration', requirements: ['id' => '\d+'], methods: ["GET", "POST"])]
    /**
     * Suppresion d'une illustration pour la mise à jour d'un trick
     *
     * @param #[MapEntity(expr: $illustration
     *
     * @return Response
     */
    public function delete(#[MapEntity(expr: 'repository.find(id)')] Illustration $illustration): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Suppression de l'illustration
        $this->illustrationService->delete($illustration);

        return $this->redirectToRoute('trick_update', [
            "slug" => $illustration->getTrick()->getSlug()
        ]);
    }
}
