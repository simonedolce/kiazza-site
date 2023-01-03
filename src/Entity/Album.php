<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urlYoutube = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urlBandcamp = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urlSpotify = null;

    #[ORM\Column(length: 100)]
    private ?string $nomeAlbum = null;

    #[ORM\Column]
    private ?int $numeroTracce = null;

    #[ORM\OneToMany(mappedBy: 'idAlbum', targetEntity: VideoAlbum::class, orphanRemoval: true)]
    private Collection $videos;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Immagine $immagine = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 100)]
    private ?string $nomeArtista = null;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
        $this->utenti = new ArrayCollection();
    }

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

    public function getUrlBandcamp(): ?string
    {
        return $this->urlBandcamp;
    }

    public function setUrlBandcamp(?string $urlBandcamp): self
    {
        $this->urlBandcamp = $urlBandcamp;

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

    public function getNomeAlbum(): ?string
    {
        return $this->nomeAlbum;
    }

    public function setNomeAlbum(string $nomeAlbum): self
    {
        $this->nomeAlbum = $nomeAlbum;

        return $this;
    }

    public function getNumeroTracce(): ?int
    {
        return $this->numeroTracce;
    }

    public function setNumeroTracce(int $numeroTracce): self
    {
        $this->numeroTracce = $numeroTracce;

        return $this;
    }

    /**
     * @return Collection<int, VideoAlbum>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(VideoAlbum $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
            $video->setIdAlbum($this);
        }

        return $this;
    }

    public function removeVideo(VideoAlbum $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getIdAlbum() === $this) {
                $video->setIdAlbum(null);
            }
        }

        return $this;
    }







    public function getImmagine(): ?Immagine
    {
        return $this->immagine;
    }

    public function setImmagine(Immagine $immagine): self
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
