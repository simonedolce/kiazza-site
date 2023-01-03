<?php

namespace App\Entity;

use App\Repository\BannerProfiloRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BannerProfiloRepository::class)]
class BannerProfilo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'bannerProfilo', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $idUtente = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Immagine $idImmagine = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUtente(): ?user
    {
        return $this->idUtente;
    }

    public function setIdUtente(user $idUtente): self
    {
        $this->idUtente = $idUtente;

        return $this;
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
