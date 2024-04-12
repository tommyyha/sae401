<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[UniqueEntity(fields: ['Email'], message: 'There is already an account with this Email')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Username = null;

    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[ORM\Column(length: 255)]
    private ?string $Password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ProfilePicture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ProfileCover = null;

    #[ORM\OneToMany(targetEntity: Connexion::class, mappedBy: 'UserID')]
    private Collection $connexions;

    #[ORM\OneToMany(targetEntity: Publication::class, mappedBy: 'UserID')]
    private Collection $publications;


    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'UserID')]
    private Collection $commentaires;

    #[ORM\OneToMany(targetEntity: Follow::class, mappedBy: 'UserID')]
    private Collection $follows;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Bio = null;

    #[ORM\Column(nullable: true)]
    private ?int $EcoScore = null;

    #[ORM\OneToMany(targetEntity: Like::class, mappedBy: 'user')]
    private Collection $likes;
    
    public function __construct()
    {
        $this->connexions = new ArrayCollection();
        $this->publications = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->follows = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->Email; // Ou toute autre propriété qui représente l'identifiant de l'utilisateur
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(string $Username): static
    {
        $this->Username = $Username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): static
    {
        $this->Password = $Password;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->ProfilePicture;
    }

    public function setProfilePicture(?string $ProfilePicture): static
    {
        $this->ProfilePicture = $ProfilePicture;

        return $this;
    }

    public function getProfileCover(): ?string
    {
        return $this->ProfileCover;
    }

    public function setProfileCover(?string $ProfileCover): static
    {
        $this->ProfileCover = $ProfileCover;

        return $this;
    }

    public function getConnexions(): Collection
    {
        return $this->connexions;
    }

    public function addConnexion(Connexion $connexion): static
    {
        if (!$this->connexions->contains($connexion)) {
            $this->connexions->add($connexion);
            $connexion->setUserID($this);
        }

        return $this;
    }

    public function removeConnexion(Connexion $connexion): static
    {
        if ($this->connexions->removeElement($connexion)) {
            if ($connexion->getUserID() === $this) {
                $connexion->setUserID(null);
            }
        }

        return $this;
    }

    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function addPublication(Publication $publication): static
    {
        if (!$this->publications->contains($publication)) {
            $this->publications->add($publication);
            $publication->setUserID($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): static
    {
        if ($this->publications->removeElement($publication)) {
            if ($publication->getUserID() === $this) {
                $publication->setUserID(null);
            }
        }

        return $this;
    }

    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setUserID($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            if ($commentaire->getUserID() === $this) {
                $commentaire->setUserID(null);
            }
        }

        return $this;
    }

    public function getFollows(): Collection
    {
        return $this->follows;
    }

    public function addFollow(Follow $follow): static
    {
        if (!$this->follows->contains($follow)) {
            $this->follows->add($follow);
            $follow->setUserID($this);
        }

        return $this;
    }

    public function removeFollow(Follow $follow): static
    {
        if ($this->follows->removeElement($follow)) {
            if ($follow->getUserID() === $this) {
                $follow->setUserID(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }
    public function supportsClass(string $class)
    {
        return $class === 'App\Entity\Utilisateur';
    }

    public function getBio(): ?string
    {
        return $this->Bio;
    }

    public function setBio(?string $Bio): static
    {
        $this->Bio = $Bio;

        return $this;
    }

    public function getEcoScore(): ?int
    {
        return $this->EcoScore;
    }

    public function setEcoScore(?int $EcoScore): static
    {
        $this->EcoScore = $EcoScore;

        return $this;
    }

    /**
     * @return Collection<int, Like>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): static
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setUser($this);
        }

        return $this;
    }

    public function removeLike(Like $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getUser() === $this) {
                $like->setUser(null);
            }
        }

        return $this;
    }
}
