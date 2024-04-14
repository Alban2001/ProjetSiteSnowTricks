<?php

namespace App\Service;

use App\Entity\Illustration;

interface IllustrationServiceInterface
{
    public function find(int $id);
    public function delete(Illustration $illustration);
}