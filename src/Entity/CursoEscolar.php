<?php

namespace App\Entity;

use App\Repository\CursoEscolarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CursoEscolarRepository::class)]
class CursoEscolar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $anioInicio = null;

    #[ORM\Column]
    private ?int $anioFin = null;

    /**
     * @var Collection<int, Periodo>
     */
    #[ORM\OneToMany(targetEntity: Periodo::class, mappedBy: 'cursos')]
    private Collection $periodos;

    public function __construct()
    {
        $this->periodos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnioInicio(): ?int
    {
        return $this->anioInicio;
    }

    public function setAnioInicio(int $anioInicio): static
    {
        $this->anioInicio = $anioInicio;

        return $this;
    }

    public function getAnioFin(): ?int
    {
        return $this->anioFin;
    }

    public function setAnioFin(int $anioFin): static
    {
        $this->anioFin = $anioFin;

        return $this;
    }

    /**
     * @return Collection<int, Periodo>
     */
    public function getPeriodos(): Collection
    {
        return $this->periodos;
    }

    public function addPeriodo(Periodo $periodo): static
    {
        if (!$this->periodos->contains($periodo)) {
            $this->periodos->add($periodo);
            $periodo->setCursos($this);
        }

        return $this;
    }

    public function removePeriodo(Periodo $periodo): static
    {
        if ($this->periodos->removeElement($periodo)) {
            // set the owning side to null (unless already changed)
            if ($periodo->getCursos() === $this) {
                $periodo->setCursos(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'anioInicio' => $this->getAnioInicio(),
            'anioFin' => $this->getAnioFin()
        ];
    }
}
