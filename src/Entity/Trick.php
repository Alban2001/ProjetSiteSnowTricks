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

    /**
     * Method getId
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Method setNom
     *
     * @param string $nom
     *
     * @return static
     */
    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Method getNom
     *
     * @return string
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * Récupération de l'illustration principale
     *
     * @return static
     */
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

    /**
     * Method getIllustrationPrincipale
     *
     * @return Illustration
     */
    public function getIllustrationPrincipale(): ?Illustration
    {
        return $this->illustrationPrincipale;
    }

    /**
     * Method setDescription
     *
     * @param string $description
     *
     * @return static
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Method getDescription
     *
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Method setSlug
     *
     * @param string $slug
     *
     * @return static
     */
    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Method getSlug
     *
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Method setDateCreation
     *
     * @param \DateTimeInterface $date_creation
     *
     * @return static
     */
    public function setDateCreation(\DateTimeInterface $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    /**
     * Method getDateCreation
     *
     * @return \DateTimeInterface
     */
    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    /**
     * Method setDateDerniereMAJ
     *
     * @param \DateTimeInterface $date_derniere_MAJ
     *
     * @return static
     */
    public function setDateDerniereMAJ(\DateTimeInterface $date_derniere_MAJ): static
    {
        $this->date_derniere_MAJ = $date_derniere_MAJ;

        return $this;
    }

    /**
     * Method getDateDerniereMAJ
     *
     * @return \DateTimeInterface
     */
    public function getDateDerniereMAJ(): ?\DateTimeInterface
    {
        return $this->date_derniere_MAJ;
    }

    /**
     * Method setVideoPrincipale
     *
     * @param string $videoPrincipale [explicite description]
     *
     * @return static
     */
    public function setVideoPrincipale(string $videoPrincipale): static
    {
        $this->videoPrincipale = $videoPrincipale;

        return $this;
    }

    /**
     * Method getVideoPrincipale
     *
     * @return string
     */
    public function getVideoPrincipale(): ?string
    {
        return $this->videoPrincipale;
    }

    /**
     * Method setImagePrincipale
     *
     * @param string $imagePrincipale [explicite description]
     *
     * @return static
     */
    public function setImagePrincipale(string $imagePrincipale): static
    {
        $this->imagePrincipale = $imagePrincipale;

        return $this;
    }

    /**
     * Method getImagePrincipale
     *
     * @return string
     */
    public function getImagePrincipale(): ?string
    {
        return $this->imagePrincipale;
    }

    /**
     * Method setUtilisateur
     *
     * @param ?Utilisateur $utilisateur [explicite description]
     *
     * @return static
     */
    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Method getUtilisateur
     *
     * @return Utilisateur
     */
    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    /**
     * Method getGroupe
     *
     * @return Groupe
     */
    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    /**
     * Method setGroupe
     *
     * @param ?Groupe $groupe
     *
     * @return static
     */
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

    /**
     * Method addCommentaire
     *
     * @param Commentaire $commentaire 
     *
     * @return static
     */
    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setTrick($this);
        }

        return $this;
    }

    /**
     * Method removeCommentaire
     *
     * @param Commentaire $commentaire
     *
     * @return static
     */
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

    /**
     * Method addIllustration
     *
     * @param Illustration $illustration
     *
     * @return static
     */
    public function addIllustration(Illustration $illustration): static
    {
        if (!$this->illustrations->contains($illustration)) {
            $this->illustrations->add($illustration);
            $illustration->setTrick($this);
        }

        return $this;
    }

    /**
     * Method removeIllustration
     *
     * @param Illustration $illustration [explicite description]
     *
     * @return static
     */
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

    /**
     * Method addVideo
     *
     * @param Video $video 
     *
     * @return static
     */
    public function addVideo(Video $video): static
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
            $video->setTrick($this);
        }

        return $this;
    }

    /**
     * Method removeVideo
     *
     * @param Video $video
     *
     * @return static
     */
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
