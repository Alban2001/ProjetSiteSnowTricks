<?php

namespace App\Service;

use App\Entity\Illustration;
use App\Entity\Trick;
use App\Entity\Utilisateur;
use App\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class TrickService implements TrickServiceInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    // Sélection et affichage de l'ensemble des tricks
    public function findAll()
    {
        $tricks = $this->entityManager->getRepository(Trick::class)->findAll();

        // Récupération de l'image principale du trick
        foreach ($tricks as $trick) {
            $trick->setIllustrationPrincipale();
        }

        return $tricks;
    }

    // Récupération du trick en fonction de son slug avec toutes ses informations
    public function findOneBySlug(string $slug, int $page): ?Trick
    {
        $trick = $this->entityManager->getRepository(Trick::class)->findOneBySlug($slug, $page);

        // Affectation de l'image principale
        $trick->setIllustrationPrincipale();

        return $trick;
    }

    // Suppresion d'un trick
    public function delete(Trick $trick)
    {
        // Supression des images physiques dans le dossier upload
        $imgTrick = new Filesystem();
        foreach ($trick->getIllustrations() as $image) {
            $imgTrick->remove([__DIR__ . "/../../public/images/upload/" . $image->getNom()]);
        }

        // Suppression du trick dans la BDD
        $this->entityManager->remove($trick);
        $this->entityManager->flush();
    }

    // Génération d'une image physique
    function generateImage(string $filename)
    {
        // Définition d'un nom
        $image = uniqid('', true) . '.jpg';

        // Création de l'image avec le fichier temporaire récupéré associée au nom
        $file = new UploadedFile($filename, $image);

        // Déplacement de l'image dans le dossier upload
        $file->move(__DIR__ . "/../../public/images/upload/", $image);

        return $image;
    }

    // Création d'un trick
    public function create(Trick $trick, Utilisateur $user)
    {
        // Ajout du trick dans la BDD
        $trick->setDateCreation(new \DateTime('now'));
        $trick->setDateDerniereMAJ(new \DateTime('now'));
        // Définition du slug
        $trick->setSlug(str_replace(" ", "-", strtolower($trick->getNom())));
        $trick->setGroupe($trick->getGroupe());
        $trick->setUtilisateur($user);   //TO DO : ajouter l'ID utilisateur

        // Création des illustrations

        // Ajout de l'image principale
        $imagePrincipale = new Illustration();
        $imagePrincipale->setPrincipale(1);
        $imagePhysiquePrinc = TrickService::generateImage($trick->getImagePrincipale());
        $imagePrincipale->setNom($imagePhysiquePrinc);
        $trick->addIllustration($imagePrincipale);

        // Ajout des illustrations dans la BDD
        for ($i = 0; $i <= $trick->getIllustrations()->count(); $i++) {
            // Si les objets illustration sont remplis
            if ($trick->getIllustrations()[$i]->getNom() !== null) {
                $trick->getIllustrations()[$i]->setPrincipale(0);
                $imagePhysique = TrickService::generateImage($trick->getIllustrations()[$i]->getNom());
                $trick->getIllustrations()[$i]->setNom($imagePhysique);
            } else {
                // Suppression des objets illustration non remplis
                $trick->removeIllustration($trick->getIllustrations()[$i]);
            }
        }

        // Ajout de l'image principale
        $videoPrincipale = new Video();
        $videoPrincipale->setNom(str_replace("watch?v=", "embed/", $trick->getVideoPrincipale()));
        $videoPrincipale->setDateCreation(new \DateTime('now'));
        $videoPrincipale->setType("YouTube");
        $trick->addVideo($videoPrincipale);

        // Ajout des vidéos dans la BDD
        for ($k = 0; $k <= $trick->getVideos()->count(); $k++) {
            // Si les objets video sont remplis
            if ($trick->getVideos()[$k]->getNom() !== null) {
                $trick->getVideos()[$k]->setNom(str_replace("watch?v=", "embed/", $trick->getVideos()[$k]->getNom()));
                $trick->getVideos()[$k]->setDateCreation(new \DateTime('now'));
                $trick->getVideos()[$k]->setType("YouTube");
            } else {
                // Suppression des objets video non remplis
                $trick->removeVideo($trick->getVideos()[$k]);
            }
        }

        $this->entityManager->persist($trick);
        $this->entityManager->flush();
    }

    // Mise à jour du trick
    public function update(Trick $trick, Request $request, Utilisateur $user)
    {
        // Mise à jour dans la BDD
        $trick->setDateDerniereMAJ(new \DateTime('now'));
        $trick->setGroupe($trick->getGroupe());
        $trick->setUtilisateur($user);

        // Récupération des images physiques (file)
        $illustrations = $request->files->get("trick")["illustrations"];

        if ($illustrations !== null) {
            // Mise à jour des photos
            for ($i = 0; $i <= count($illustrations) - 1; $i++) {
                // Si les objets illustration sont remplis
                if ($illustrations[$i]["nom"] !== null) {
                    $imagePhysique = TrickService::generateImage($illustrations[$i]["nom"]);
                    $trick->getIllustrations()[$i]->setNom($imagePhysique);
                }
            }
        }

        // Mise à jour des vidéos
        for ($k = 0; $k <= $trick->getVideos()->count() - 1; $k++) {
            // Si les objets video sont remplis
            if ($trick->getVideos()[$k]->getNom() !== null) {
                $trick->getVideos()[$k]->setNom(str_replace("watch?v=", "embed/", $trick->getVideos()[$k]->getNom()));
            }
        }

        $this->entityManager->persist($trick);
        $this->entityManager->flush();
    }
}