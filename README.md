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

=> Dans le terminal de Symfony, effectuer les commandes : `cd ProjetSiteSnowTricks` puis `composer install` afin de pouvoir installer les fichiers manquants de composer et mettre à jour. Un message d'erreur va apparaître, car dans le fichier .env, il manque la variable **_DATABASE_URL_**.

### Configurer le fichier .env

- => Remplissez la variable **_DATABASE_URL_** afin de permettre au projet de communiquer avec la base de données.
  Exemple :

```
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
```

- => Veuillez aussi compléter la variable **_MAILER_DSN_** qui concerne l'envoi de mail pour la création de compte et réinitialisation de mot de passe

- Mettez également à jour la variable **_APP_ENV=prod_** afin de pouvoir tester les pages d'erreurs par exemple si la page n'existe pas.

Afin d'ajouter la base de données du projet dans votre SGBDR, veuillez simplement lancer les commandes dans le terminal de Symfony : `php bin/console make:migration` puis `php bin/console doctrine:migrations:migrate`.

- Afin d'ajouter des insertions automatique de 10 tricks, lancez la commande : `php bin/console doctrine:fixtures:load` pour avoir une base sur le site.

## Guide d'utilisation

### Compte utilisateur

En arrivant sur le site en simple visiteur, vous aurez juste les accès pour lire les tricks ainsi que les commentaires et rien d'autres.
Si vous souhaitez en ajouter, modifier, supprimer des tricks ou écrire un commentaire sur les tricks d'autres utilisateurs, vous devez créer un compte utilisateur : onglet **_Se connecter_** > Lien **_Pas de Compte ?_** puis remplissez les champs : nom d'utilisateur, email et mot de passe. Une fois le compte créé, vous serez automatiquement connecté.
