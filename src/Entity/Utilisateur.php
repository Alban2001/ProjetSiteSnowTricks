<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $username = null;

    #[ORM\Column(length: 125)]
    private ?string $email_address = null;

    #[ORM\Column(length: 125)]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $valid = null;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Trick::class)]
    private Collection $tricks;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Commentaire::class)]
    private Collection $commentaires;

    public function __construct()
    {
        $this->tricks = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setEmailAddress(string $email_address): static
    {
        $this->email_address = $email_address;

        return $this;
    }
    public function getEmailAddress(): ?string
    {
        return $this->email_address;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
    public function getPassword(): ?string
    {
        return $this->password;
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

    public function setValid(int $valid): static
    {
        $this->valid = $valid;

        return $this;
    }
    public function getValid(): ?int
    {
        return $this->valid;
    }

    /**
     * @return Collection<int, Trick>
     */
    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    public function addTrick(Trick $trick): static
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks->add($trick);
            $trick->setUtilisateur($this);
        }

        return $this;
    }

    public function removeTrick(Trick $trick): static
    {
        if ($this->tricks->removeElement($trick)) {
            // set the owning side to null (unless already changed)
            if ($trick->getUtilisateur() === $this) {
                $trick->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setUtilisateur($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUtilisateur() === $this) {
                $commentaire->setUtilisateur(null);
            }
        }

        return $this;
    }
}
