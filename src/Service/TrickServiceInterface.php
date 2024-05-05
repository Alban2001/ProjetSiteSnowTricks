<?php

namespace App\Service;

use App\Entity\Trick;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;

interface TrickServiceInterface
{
    public function findAll(int $page, int $number);
    public function countTricks();
    public function findOneBySlug(string $slug);
    public function delete(Trick $trick);
    public function create(Trick $trick, Utilisateur $user);
    public function update(Trick $trick, Request $request, Utilisateur $user);
}