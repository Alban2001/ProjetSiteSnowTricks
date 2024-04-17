<?php

namespace App\Service;

use App\Entity\Trick;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;

interface TrickServiceInterface
{
    public function findAll();
    public function findOneBySlug(string $slug, int $page);
    public function delete(Trick $trick);
    public function create(Trick $trick, Utilisateur $user);
    public function update(Trick $trick, Request $request, Utilisateur $user);
}