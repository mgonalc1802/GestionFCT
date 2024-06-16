<?php

namespace App\Entity;

use App\Repository\PeriodoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeriodoRepository::class)]
class Periodo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaInicio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaFin = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'periodos')]
    private Collection $usuarios;

    #[ORM\ManyToOne(inversedBy: 'periodos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CursoEscolar $cursos = null;

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(\DateTimeInterface $fechaInicio): static
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fechaFin;
    }

    public function setFechaFin(\DateTimeInterface $fechaFin): static
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsuarios(): Collection
    {
        return $this->usuarios;
    }

    public function addUsuario(User $usuario): static
    {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios->add($usuario);
            $usuario->addPeriodo($this);
        }

        return $this;
    }

    public function removeUsuario(User $usuario): static
    {
        if ($this->usuarios->removeElement($usuario)) {
            $usuario->removePeriodo($this);
        }

        return $this;
    }

    public function getCursos(): ?CursoEscolar
    {
        return $this->cursos;
    }

    public function setCursos(?CursoEscolar $cursos): static
    {
        $this->cursos = $cursos;

        return $this;
    }

    public function __toString()
    {
        return $this->fechaInicio->format('Y-m-d') . "/" . $this->fechaFin->format('Y-m-d');
    }
}
