<?php

namespace App\Service;

use App\Entity\Commentaire;
use App\Entity\Trick;
use App\Entity\Utilisateur;

interface CommentServiceInterface
{
    public function add(Commentaire $comment, Trick $trick, Utilisateur $user);
    public function displayAllCommentsBySlug(string $slug, int $page, int $number);
    public function countCommentsBySlug(string $slug, int $page);
}