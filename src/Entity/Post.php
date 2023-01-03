<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'post')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $idUtente = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Immagine $idImmagine = null;

    #[ORM\Column(length: 100)]
    private ?string $titolo = null;

    #[ORM\Column(length: 500)]
    private ?string $text = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUtente(): ?user
    {
        return $this->idUtente;
    }

    public function setIdUtente(?user $idUtente): self
    {
        $this->idUtente = $idUtente;

        return $this;
    }

    public function getIdImmagine(): ?Immagine
    {
        return $this->idImmagine;
    }

    public function setIdImmagine(?Immagine $idImmagine): self
    {
        $this->idImmagine = $idImmagine;

        return $this;
    }

    public function getTitolo(): ?string
    {
        return $this->titolo;
    }

    public function setTitolo(string $titolo): self
    {
        $this->titolo = $titolo;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
