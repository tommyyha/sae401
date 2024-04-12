<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: PublicationRepository::class)]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateTime = null;



    #[ORM\ManyToOne(inversedBy: 'publications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $UserID = null;


    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'PostID', cascade: ["remove"])]
    private Collection $commentaires;

    #[ORM\Column(length: 255)]
    private ?string $Post_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Post_content = null;

    #[ORM\OneToMany(targetEntity: Like::class, mappedBy: 'publication')]
    private Collection $likes;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostID(): ?int
    {
        return $this->PostID;
    }

    public function setPostID(int $PostID): static
    {
        $this->PostID = $PostID;

        return $this;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->DateTime;
    }

    public function setDateTime(\DateTimeInterface $DateTime): static
    {
        $this->DateTime = $DateTime;

        return $this;
    }


    public function getUserID(): ?Utilisateur
    {
        return $this->UserID;
    }

    public function setUserID(?Utilisateur $UserID): static
    {
        $this->UserID = $UserID;

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
            $commentaire->setPostID($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getPostID() === $this) {
                $commentaire->setPostID(null);
            }
        }

        return $this;
    }

    public function getPostType(): ?string
    {
        return $this->Post_type;
    }

    public function setPostType(string $Post_type): static
    {
        $this->Post_type = $Post_type;

        return $this;
    }

    public function getPostContent(): ?string
    {
        return $this->Post_content;
    }

    public function setPostContent(?string $Post_content): static
    {
        $this->Post_content = $Post_content;

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
            $like->setPublication($this);
        }

        return $this;
    }

    public function removeLike(Like $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getPublication() === $this) {
                $like->setPublication(null);
            }
        }

        return $this;
    }
}
