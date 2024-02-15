<?php

namespace App\Service;

use App\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;

class TrickService implements TrickServiceInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function findAll()
    {
        $repository = $this->entityManager->getRepository(Trick::class);

        // Selection et affichage de tous les tricks
        $tricks = $repository->findAll();
        foreach ($tricks as $trick) {
            $trick->setIllustrationPrincipale();
        }

        return $tricks;
    }

    public function findOneBySlug(string $slug, int $page): ?Trick
    {
        $repository = $this->entityManager->getRepository(Trick::class);

        // Selection et affichage des détails complets d'un trick
        $trick = $repository->findOneBySlug($slug, $page);
        $trick->setIllustrationPrincipale();

        return $trick;
    }

    public function countCommentsTrick(string $slug): int
    {
        $repository = $this->entityManager->getRepository(Trick::class);

        // Selection et affichage des détails complets d'un trick
        return $repository->countCommentsTrick($slug);
    }

    public function delete(Trick $trick)
    {
        $this->entityManager->remove($trick);
        $this->entityManager->flush();
    }
}