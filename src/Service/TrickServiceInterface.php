<?php

namespace App\Service;

use App\Entity\Trick;
use Symfony\Component\HttpFoundation\Request;

interface TrickServiceInterface
{
    public function findAll();
    public function findOneBySlug(string $slug, int $page);
    public function delete(Trick $trick);
    public function create(Trick $trick);
    public function update(Trick $trick, Request $request);
}