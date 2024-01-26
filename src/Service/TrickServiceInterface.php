<?php

namespace App\Service;

use App\Entity\Trick;

interface TrickServiceInterface
{
    public function findAll();
    public function findOneBySlug(string $slug, int $page);
}