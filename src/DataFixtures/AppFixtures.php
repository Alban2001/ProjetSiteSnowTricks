<?php
namespace App\DataFixtures;

use App\Entity\Commentaire;
use App\Entity\Groupe;
use App\Entity\Illustration;
use App\Entity\Trick;
use App\Entity\Utilisateur;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    // Création automatique et instantané de 5 tricks
    public function load(ObjectManager $manager)
    {
        // Ajout d'un utilisateur
        $user = new Utilisateur();
        $user->setUsername("avoiriot");
        $user->setEmailAddress("alban.voiriot@gmail.com");
        $user->setPassword('$2y$10$mdJ47k4Myp2cbQFmHYJteuABxkl6WWkpDoSGNCKwRO/InQC3SX8ZG');
        $user->setDateCreation(new \DateTime('now'));
        $user->setVerified(true);
        $manager->persist($user);

        // Ajout d'un groupe
        $groupe = new Groupe();
        $groupe->setNom("Tail Grab");
        $manager->persist($groupe);

        $manager->flush();

        // Ajout de 5 tricks
        for ($i = 1; $i <= 10; $i++) {
            $trick = new Trick();
            $trick->setNom("trick_" . $i);
            $trick->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum");
            $trick->setSlug("trick-" . $i);
            $trick->setDateCreation(new \DateTime('now'));
            $trick->setDateDerniereMAJ(new \DateTime('now'));
            $trick->setGroupe($groupe);
            $trick->setUtilisateur($user);
            $manager->persist($trick);

            // Ajout de 3 images
            for ($k = 1; $k <= 3; $k++) {
                $img = new Illustration();
                $img->setNom("trick_" . $k . ".jpg");
                if ($k == 1) {
                    $img->setPrincipale(1);
                } else {
                    $img->setPrincipale(0);
                }
                $img->setTrick($trick);
                $manager->persist($img);
            }

            // Ajout de 3 vidéos
            for ($j = 1; $j <= 3; $j++) {
                $video = new Video();
                $video->setNom("https://www.youtube.com/embed/vQ9k2cf7xJE");
                $video->setType("YouTube");
                $video->setDateCreation(new \DateTime('now'));
                $video->setTrick($trick);
                $manager->persist($video);
            }

            // Ajout de 5 commentaires
            for ($f = 1; $f <= 5; $f++) {
                $comment = new Commentaire();
                $comment->setContenu("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum");
                $comment->setDateCreation(new \DateTime('now'));
                $comment->setTrick($trick);
                $comment->setUtilisateur($user);
                $manager->persist($comment);
            }
            $manager->flush();
        }
        $manager->flush();
    }
}