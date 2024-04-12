<?php

namespace App\Entity;

use App\Repository\FollowRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FollowRepository::class)]
class Follow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'follows')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $UserID = null;

    #[ORM\ManyToOne(inversedBy: 'follows')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $FollowerID = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFollowerID(): ?Utilisateur
    {
        return $this->FollowerID;
    }

    public function setFollowerID(?Utilisateur $FollowerID): static
    {
        $this->FollowerID = $FollowerID;

        return $this;
    }
}
