<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TrickRepository::class)]
#[UniqueEntity(
    fields: ['slug'],
    message: 'Désolé, mais ce nom existe déja !')]
class Trick
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le nom du trick ne peut pas être vide !")]
    private ?string $nom = null;

    #[Assert\NotBlank(message: "Vous devez choisir une image principale", groups: ["Update"])]
    private ?string $imagePrincipale = null;

    private ?Illustration $illustrationPrincipale = null;

    #[Assert\NotBlank(message: "Vous devez choisir une vidéo principale", groups: ["Update"])]
    private ?string $videoPrincipale = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "La description ne peut pas être vide !")]
    private ?string $description = null;

    #[ORM\Column(length: 50, type: 'string', unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_derniere_MAJ = null;

    #[ORM\ManyToOne(inversedBy: 'tricks')]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'tricks')]
    private ?Groupe $groupe = null;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: Commentaire::class, cascade: ["persist", "remove"])]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: Illustration::class, cascade: ["persist", "remove"])]
    private Collection $illustrations;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: Video::class, cascade: ["persist", "remove"])]
    private Collection $videos;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->illustrations = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }

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

    // Récupération de l'illustration principale
    public function setIllustrationPrincipale(): static
    {
        foreach ($this->illustrations as $illustration) {
            if (1 === $illustration->getPrincipale()) {
                $this->illustrationPrincipale = $illustration;
                break;
            }
        }

        return $this;
    }

    public function getIllustrationPrincipale(): ?Illustration
    {
        return $this->illustrationPrincipale;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
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

    public function setDateDerniereMAJ(\DateTimeInterface $date_derniere_MAJ): static
    {
        $this->date_derniere_MAJ = $date_derniere_MAJ;

        return $this;
    }
    public function getDateDerniereMAJ(): ?\DateTimeInterface
    {
        return $this->date_derniere_MAJ;
    }

    public function setVideoPrincipale(string $videoPrincipale): static
    {
        $this->videoPrincipale = $videoPrincipale;

        return $this;
    }

    public function getVideoPrincipale(): ?string
    {
        return $this->videoPrincipale;
    }

    public function setImagePrincipale(string $imagePrincipale): static
    {
        $this->imagePrincipale = $imagePrincipale;

        return $this;
    }

    public function getImagePrincipale(): ?string
    {
        return $this->imagePrincipale;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): static
    {
        $this->groupe = $groupe;

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
            $commentaire->setTrick($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getTrick() === $this) {
                $commentaire->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Illustration>
     */
    public function getIllustrations(): Collection
    {
        return $this->illustrations;
    }

    public function addIllustration(Illustration $illustration): static
    {
        if (!$this->illustrations->contains($illustration)) {
            $this->illustrations->add($illustration);
            $illustration->setTrick($this);
        }

        return $this;
    }

    public function removeIllustration(Illustration $illustration): static
    {
        if ($this->illustrations->removeElement($illustration)) {
            // set the owning side to null (unless already changed)
            if ($illustration->getTrick() === $this) {
                $illustration->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): static
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
            $video->setTrick($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): static
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getTrick() === $this) {
                $video->setTrick(null);
            }
        }

        return $this;
    }
}
