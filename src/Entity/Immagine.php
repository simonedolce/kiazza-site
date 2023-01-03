<?php

namespace App\Entity;
use App\Repository\ImmagineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImmagineRepository::class)]
class Immagine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nomeFile = null;

    #[ORM\Column(length: 100)]
    private ?string $path = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dimensione $dimensione = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomeFile(): ?string
    {
        return $this->nomeFile;
    }

    public function setNomeFile(string $nomeFile): self
    {
        $this->nomeFile = $nomeFile;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getDimensione(): ?dimensione
    {
        return $this->dimensione;
    }

    public function setDimensione(?dimensione $dimensione): self
    {
        $this->dimensione = $dimensione;

        return $this;
    }
}
