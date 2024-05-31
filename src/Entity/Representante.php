<?php

namespace App\Entity;

use App\Repository\RepresentanteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepresentanteRepository::class)]
class Representante
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 9)]
    private ?string $dni = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $apellido1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $apellido2 = null;

    #[ORM\Column(length: 255)]
    private ?string $cargo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido1(): ?string
    {
        return $this->apellido1;
    }

    public function setApellido1(string $apellido1): static
    {
        $this->apellido1 = $apellido1;

        return $this;
    }

    public function getApellido2(): ?string
    {
        return $this->apellido2;
    }

    public function setApellido2(?string $apellido2): static
    {
        $this->apellido2 = $apellido2;

        return $this;
    }

    public function getCargo(): ?string
    {
        return $this->cargo;
    }

    public function setCargo(string $cargo): static
    {
        $this->cargo = $cargo;

        return $this;
    }

    public function __toString()
    {
        return 'DNI: ' .  $this->dni . ' Nombre: ' .  $this->nombre . ' ' . $this->apellido1 . ' ' . $this->apellido2;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'dni' => $this->getDni(),
            'nombre' => $this->getNombre(),
            'apellido1' => $this->getApellido1(),
            'apellido2' => $this->getApellido2(),
            'cargo' => $this->getCargo()
        ];
    }
}
