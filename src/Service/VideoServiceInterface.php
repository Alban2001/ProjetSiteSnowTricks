<?php

namespace App\Service;

use App\Entity\Video;

interface VideoServiceInterface
{
    public function find(int $id);
    public function delete(Video $video);
}