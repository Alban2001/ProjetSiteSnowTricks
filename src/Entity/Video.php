<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 250)]
    private ?string $nom = null;

    #[ORM\Column(length: 25)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;

    #[ORM\ManyToOne(inversedBy: 'videos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trick $trick = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
    public function getType(): ?string
    {
        return $this->type;
    }
    public function setDateCreation(\DateTimeInterface $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }
    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }
    public function setTrick(?Trick $trick): static
    {
        $this->trick = $trick;

        return $this;
    }
    public function getTrick(): ?Trick
    {
        return $this->trick;
    }
}
