<?php

namespace App\Service;

use App\Entity\Trick;

interface TrickServiceInterface
{
    public function findAll();
    public function findOneBySlug(string $slug, int $page);
    public function delete(Trick $trick);
    public function create(Trick $trick);
    public function update(Trick $trick);
}