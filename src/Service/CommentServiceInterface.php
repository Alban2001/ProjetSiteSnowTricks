<?php

namespace App\Service;

use App\Entity\Commentaire;
use App\Entity\Trick;

interface CommentServiceInterface
{
    public function add(Commentaire $comment, Trick $trick);
}