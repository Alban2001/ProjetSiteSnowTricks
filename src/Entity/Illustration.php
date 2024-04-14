<?php

namespace App\Entity;

use App\Repository\IllustrationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IllustrationRepository::class)]
class Illustration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 125)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $principale = null;

    #[ORM\ManyToOne(inversedBy: 'illustrations')]
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

    public function setPrincipale(int $principale): static
    {
        $this->principale = $principale;

        return $this;
    }
    public function getPrincipale(): ?int
    {
        return $this->principale;
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
