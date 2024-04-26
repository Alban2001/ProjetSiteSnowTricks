# PROJET 6 : Développez de A à Z le site communautaire SnowTricks

**Date de création** : 25 avril 2024
**Date de la dernière modification** : 25 avril 2024
**Auteur** : Alban VOIRIOT
**Informations techniques** :

- **Technologies** : HTML, CSS, PHP, Symfony, SQL, JavaScript, Bootstrap, MySQL
- **Version de Symfony** : 6.4.6
- **Version de PHP** : 8.1.10
- **Version de MySQL** : 5.7.11
- **Version de Bootstrap** : 5.0.2

## Sommaire

- [Contexte](#contexte)
- [Installation](#installation)
  - [Télécharger le projet](#télécharger-le-projet)
  - [Configurer le fichier .env](#configurer-le-fichier-env)
  - [Dossier upload](#dossier-upload)
- [Guide d'utilisation](#guide-dutilisation)
  - [Compte utilisateur](#compte-utilisateur)

## Contexte

Ce projet a été conçu dans le cadre de ma formation de développeur d'applications PHP/Symfony (OpenClassrooms) sur la création d'un site communautaire afin que les utilsaiteurs puissent partager et communiquer leur passion pour le snowboard. Ils pourront créer leur compte afin qu'ils puissent ajouter leur trick avec des vidéos, images, une description et mettre des commentaires dans ceux des autres.

## Installation

### Télécharger le projet

=> Pour télécharger le dossier, veuillez effectuer la commande GIT : `git clone https://github.com/Alban2001/ProjetSiteSnowTricks.git`

### Configurer le fichier .env

- => Remplissez la variable **_DATABASE_URL_** afin de permettre au projet de communiquer avec la base de données.
  Exemple :

```
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
```

Afin d'ajouter la base de données du projet dans votre SGBDR, veuillez simplement lancer la commande dans le terminal de Symfony : `php bin/console doctrine:migrations:migrate`. Des insertions automatique de 5 tricks seront déjà présentes grâce aux fixtures afin d'avoir une base sur le site.

- => Veuillez aussi compléter la variable **_MAILER_DSN_** qui concerne l'envoi de mail pour la création de compte et réinitialisation de mot de passe

### Dossier upload

Veuillez créer un dossier **_/upload_** dans le dossier **_/public/images/_**. Celui-ci va vous permettre de stocker les images de vos tricks lors des ajouts et des modifications. Des tricks ont déjà ajouté automatiquement depuis les fixtures (**_App\DataFixtures\AppFixtures_**) mais vous rendre compte que les images physiques n'existent pas.

## Guide d'utilisation

### Compte utilisateur

En arrivant sur le site en simple visiteur, vous aurez juste les accès pour lire les tricks ainsi que les commentaires et rien d'autres.
Si vous souhaitez en ajouter, modifier, supprimer des tricks ou écrire un commentaire sur les tricks d'autres utilisateurs, vous devez créer un compte utilisateur : onglet **_Se connecter_** > Lien **_Pas de Compte ?_** puis remplissez les champs : nom d'utilisateur, email et mot de passe. Une fois le compte créé, vous serez automatiquement connecté.
