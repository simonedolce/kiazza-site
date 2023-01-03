<?php

namespace App\Entity;

use App\Repository\ConfigurazioneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfigurazioneRepository::class)]
class Configurazione
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $bio = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Immagine $idImmagineLogin = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Immagine $idImmagineLogo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getIdImmagineLogin(): ?Immagine
    {
        return $this->idImmagineLogin;
    }

    public function setIdImmagineLogin(?Immagine $idImmagineLogin): self
    {
        $this->idImmagineLogin = $idImmagineLogin;

        return $this;
    }

    public function getIdImmagineLogo(): ?Immagine
    {
        return $this->idImmagineLogo;
    }

    public function setIdImmagineLogo(?Immagine $idImmagineLogo): self
    {
        $this->idImmagineLogo = $idImmagineLogo;

        return $this;
    }
}
