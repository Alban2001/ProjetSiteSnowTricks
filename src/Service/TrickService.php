<?php

namespace App\Service;

use App\Entity\Illustration;
use App\Entity\Trick;
use App\Entity\Utilisateur;
use App\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
        //Supression des images physiques
        $imgTrick = new Filesystem();
        foreach ($trick->getIllustrations() as $image) {
            $imgTrick->remove([__DIR__ . "/../../public/images/upload/" . $image->getNom()]);
        }

        $this->entityManager->remove($trick);
        $this->entityManager->flush();
    }
    function generateImage(string $filename)
    {
        $image = uniqid('', true) . '.jpg';
        $file = new UploadedFile($filename, $image);
        $file->move(__DIR__ . "/../../public/images/upload/", $image);

        return $image;
    }
    public function create(Trick $trick)
    {
        // Ajout du trick dans la BDD
        $trick->setDateCreation(new \DateTime('now'));
        $trick->setDateDerniereMAJ(new \DateTime('now'));
        $trick->setSlug(str_replace(" ", "-", strtolower($trick->getNom())));
        $trick->setGroupe($trick->getGroupe());
        $trick->setUtilisateur(null);   //TO DO : ajouter l'ID utilisateur

        // Création des images physiques
        // Ajout de l'image principale
        $imagePrincipale = new Illustration();
        $imagePrincipale->setPrincipale(1);
        $imagePhysiquePrinc = TrickService::generateImage($trick->getImagePrincipale());
        $imagePrincipale->setNom($imagePhysiquePrinc);
        $trick->addIllustration($imagePrincipale);
        // Ajout des images dans la BDD
        for ($i = 0; $i <= $trick->getIllustrations()->count(); $i++) {
            if ($trick->getIllustrations()[$i]->getNom() !== null) {
                $trick->getIllustrations()[$i]->setPrincipale(0);
                $imagePhysique = TrickService::generateImage($trick->getIllustrations()[$i]->getNom());
                $trick->getIllustrations()[$i]->setNom($imagePhysique);
            } else {
                $trick->removeIllustration($trick->getIllustrations()[$i]);
            }
        }

        // Ajout de l'image principale
        $videoPrincipale = new Video();
        $videoPrincipale->setNom($trick->getVideoPrincipale());
        $videoPrincipale->setDateCreation(new \DateTime('now'));
        $videoPrincipale->setType("MP4");
        $trick->addVideo($videoPrincipale);
        // Ajout des vidéos dans la BDD
        for ($k = 0; $k <= $trick->getVideos()->count(); $k++) {
            if ($trick->getVideos()[$k]->getNom() !== null) {
                $trick->getVideos()[$k]->setDateCreation(new \DateTime('now'));
                $trick->getVideos()[$k]->setType("MP4");
            } else {
                $trick->removeVideo($trick->getVideos()[$k]);
            }
        }

        $this->entityManager->persist($trick);
        $this->entityManager->flush();
    }
}