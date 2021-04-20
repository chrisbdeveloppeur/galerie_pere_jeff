<?php

namespace App\Entity;

use App\Repository\SecurityTokenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SecurityTokenRepository::class)
 */
class SecurityToken
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        // Définir un jeton s'il n'y en a pas
        if ($this->token === null) {
            $this->renewToken();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Renouveller le jeton de sécurité
     */
    public function renewToken() : self
    {
        // Création d'un jeton
        $newToken = bin2hex(random_bytes(16));

        return $this->setToken($newToken);
    }
}
