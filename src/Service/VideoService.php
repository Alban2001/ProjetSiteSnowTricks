<?php

namespace App\Service;

use App\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;

class VideoService implements VideoServiceInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    // Récupération d'une vidéo en fonction de son id
    public function find(int $id): ?Video
    {
        return $this->entityManager->getRepository(Video::class)->find($id);
    }

    // Suppression d'une vidéo
    public function delete(Video $video)
    {
        $this->entityManager->remove($video);
        $this->entityManager->flush();
    }
}