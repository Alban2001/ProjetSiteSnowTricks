<?php

namespace App\Service;

use App\Entity\Illustration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class IllustrationService implements IllustrationServiceInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    // Récupération d'une illustration en fonction de son id
    public function find(int $id): ?Illustration
    {
        return $this->entityManager->getRepository(Illustration::class)->find($id);
    }

    // Suppression d'une illustration
    public function delete(Illustration $illustration)
    {
        // Traitement de l'image physique
        $imgTrick = new Filesystem();

        // Cas où on supprime l'image principale
        if ($illustration->getPrincipale() === 1) {
            // Définition d'un nouveau nom
            $image = uniqid('', true) . ".png";

            // Copie de l'image "no-image.png" pour la mettre dans le dossier upload
            $imgTrick->copy(__DIR__ . "/../../public/images/no-image.png", __DIR__ . "/../../public/images/upload/" . $image);

            // Mise à jour du nouveau de l'image dans la BDD
            $illustration->setNom($image);
        } else {
            // Suppresion de l'image physique dans le dossier upload
            $imgTrick->remove(__DIR__ . "/../../public/images/upload/" . $illustration->getNom());

            // Suppression de l'illustration dans la BDD
            $this->entityManager->remove($illustration);
        }
        $this->entityManager->flush();
    }
}