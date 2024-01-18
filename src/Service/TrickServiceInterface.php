<?php

namespace App\Service;

interface TrickServiceInterface
{
    public function findAll();
    public function findOneBySlug(string $slug);
}