<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column(type: Types::TEXT)]
    private ?string $Content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateTime = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    private ?Utilisateur $UserID = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Publication $PostID = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentID(): ?int
    {
        return $this->CommentID;
    }

    public function setCommentID(int $CommentID): static
    {
        $this->CommentID = $CommentID;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): static
    {
        $this->Content = $Content;

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

    public function getPostID(): ?Publication
    {
        return $this->PostID;
    }

    public function setPostID(?Publication $PostID): static
    {
        $this->PostID = $PostID;

        return $this;
    }
}
