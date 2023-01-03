<?php

namespace App\Entity;

use App\Repository\SingleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SingleRepository::class)]
class Single
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $urlYoutube = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $urlBandCamp = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $urlSpotify = null;

    #[ORM\Column(length: 100)]
    private ?string $nomeSingolo = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Immagine $immagine = null;

    #[ORM\ManyToOne(inversedBy: 'singles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 100)]
    private ?string $nomeArtista = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlYoutube(): ?string
    {
        return $this->urlYoutube;
    }

    public function setUrlYoutube(?string $urlYoutube): self
    {
        $this->urlYoutube = $urlYoutube;

        return $this;
    }

    public function getUrlBandCamp(): ?string
    {
        return $this->urlBandCamp;
    }

    public function setUrlBandCamp(?string $urlBandCamp): self
    {
        $this->urlBandCamp = $urlBandCamp;

        return $this;
    }

    public function getUrlSpotify(): ?string
    {
        return $this->urlSpotify;
    }

    public function setUrlSpotify(?string $urlSpotify): self
    {
        $this->urlSpotify = $urlSpotify;

        return $this;
    }

    public function getNomeSingolo(): ?string
    {
        return $this->nomeSingolo;
    }

    public function setNomeSingolo(string $nomeSingolo): self
    {
        $this->nomeSingolo = $nomeSingolo;

        return $this;
    }

    public function getImmagine(): ?Immagine
    {
        return $this->immagine;
    }

    public function setImmagine(?Immagine $immagine): self
    {
        $this->immagine = $immagine;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getNomeArtista(): ?string
    {
        return $this->nomeArtista;
    }

    public function setNomeArtista(string $nomeArtista): self
    {
        $this->nomeArtista = $nomeArtista;

        return $this;
    }
}
