<?php

namespace App\Entity;

use App\Repository\ConnexionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConnexionRepository::class)]
class Connexion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $ConnectionID = null;

    #[ORM\Column(length: 255)]
    private ?string $Provider = null;

    #[ORM\ManyToOne(inversedBy: 'connexions')]
    private ?Utilisateur $UserID = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConnectionID(): ?int
    {
        return $this->ConnectionID;
    }

    public function setConnectionID(int $ConnectionID): static
    {
        $this->ConnectionID = $ConnectionID;

        return $this;
    }

    public function getProvider(): ?string
    {
        return $this->Provider;
    }

    public function setProvider(string $Provider): static
    {
        $this->Provider = $Provider;

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
}
