<?php

namespace App\Entity;

use App\Repository\VideoAlbumRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoAlbumRepository::class)]
class VideoAlbum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $urlVideoYoutube = null;

    #[ORM\ManyToOne(inversedBy: 'videos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Album $idAlbum = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlVideoYoutube(): ?string
    {
        return $this->urlVideoYoutube;
    }

    public function setUrlVideoYoutube(string $urlVideoYoutube): self
    {
        $this->urlVideoYoutube = $urlVideoYoutube;

        return $this;
    }

    public function getIdAlbum(): ?Album
    {
        return $this->idAlbum;
    }

    public function setIdAlbum(?Album $idAlbum): self
    {
        $this->idAlbum = $idAlbum;

        return $this;
    }
}
