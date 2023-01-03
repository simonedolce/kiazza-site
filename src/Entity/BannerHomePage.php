<?php

namespace App\Entity;

use App\Repository\BannerHomePageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BannerHomePageRepository::class)]
class BannerHomePage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Immagine $idImmagine = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdImmagine(): ?Immagine
    {
        return $this->idImmagine;
    }

    public function setIdImmagine(Immagine $idImmagine): self
    {
        $this->idImmagine = $idImmagine;

        return $this;
    }
}
