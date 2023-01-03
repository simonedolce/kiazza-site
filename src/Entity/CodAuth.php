<?php

namespace App\Entity;

use App\Repository\CodAuthRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CodAuthRepository::class)]
class CodAuth
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 6)]
    private ?string $codice = null;

    #[ORM\Column(length: 50)]
    private ?string $usernameProvvisorio = null;

    #[ORM\Column(length: 30)]
    private ?string $ruolo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodice(): ?string
    {
        return $this->codice;
    }

    public function setCodice(string $codice): self
    {
        $this->codice = $codice;

        return $this;
    }

    public function getUsernameProvvisorio(): ?string
    {
        return $this->usernameProvvisorio;
    }

    public function setUsernameProvvisorio(string $usernameProvvisorio): self
    {
        $this->usernameProvvisorio = $usernameProvvisorio;

        return $this;
    }

    public function getRuolo(): ?string
    {
        return $this->ruolo;
    }

    public function setRuolo(string $ruolo): self
    {
        $this->ruolo = $ruolo;

        return $this;
    }
}
