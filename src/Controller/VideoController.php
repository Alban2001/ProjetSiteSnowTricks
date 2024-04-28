<?php

namespace App\Controller;

use App\Entity\Video;
use App\Service\VideoServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

#[Route("/video")]
class VideoController extends AbstractController
{
    public function __construct(private readonly VideoServiceInterface $videoService)
    {
    }

    #[Route('/delete/{id}', name: 'delete_video', requirements: ['id' => '\d+'], methods: ["GET", "POST"])]
    /**
     * Suppresion d'une vidéo pour la mise à jour d'un trick
     *
     * @param #[MapEntity(expr: $video [explicite description]
     *
     * @return Response
     */
    public function delete(#[MapEntity(expr: 'repository.find(id)')] Video $video): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Suppression d'une vidéo
        $this->videoService->delete($video);

        return $this->redirectToRoute('trick_update', [
            "slug" => $video->getTrick()->getSlug()
        ]);
    }
}
