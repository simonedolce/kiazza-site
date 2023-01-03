<?php

namespace App\Entity;

use App\Repository\RuoloRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RuoloRepository::class)]
class Ruolo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $systemRoleName = null;

    #[ORM\Column(length: 50)]
    private ?string $roleName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSystemRoleName(): ?string
    {
        return $this->systemRoleName;
    }

    public function setSystemRoleName(string $systemRoleName): self
    {
        $this->systemRoleName = $systemRoleName;

        return $this;
    }

    public function getRoleName(): ?string
    {
        return $this->roleName;
    }

    public function setRoleName(string $roleName): self
    {
        $this->roleName = $roleName;

        return $this;
    }
}
