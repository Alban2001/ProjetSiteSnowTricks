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
}