<?php

namespace App\Entity;

use App\Repository\DimensioneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DimensioneRepository::class)]
class Dimensione
{
    public const DIMENSIONE_QUADRATA = 0;
    public const DIMENSIONE_RETTANGOLARE = 1;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $descrizione = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescrizione(): ?string
    {
        return $this->descrizione;
    }

    public function setDescrizione(string $descrizione): self
    {
        $this->descrizione = $descrizione;

        return $this;
    }
}
