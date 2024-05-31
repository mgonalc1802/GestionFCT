<?php

namespace App\Entity;

use App\Repository\ActividadFormativoProductivaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActividadFormativoProductivaRepository::class)]
class ActividadFormativoProductiva
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    /**
     * @var Collection<int, ProgramaFormativo>
     */
    #[ORM\ManyToMany(targetEntity: ProgramaFormativo::class, mappedBy: 'activFormativProduc')]
    private Collection $programaFormativos;

    /**
     * @var Collection<int, criterioEvaluacion>
     */
    #[ORM\ManyToMany(targetEntity: CriterioEvaluacion::class, inversedBy: 'actividadesForm')]
    private Collection $citerios;

    public function __construct()
    {
        $this->programaFormativos = new ArrayCollection();
        $this->citerios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection<int, ProgramaFormativo>
     */
    public function getProgramaFormativos(): Collection
    {
        return $this->programaFormativos;
    }

    public function addProgramaFormativo(ProgramaFormativo $programaFormativo): static
    {
        if (!$this->programaFormativos->contains($programaFormativo)) {
            $this->programaFormativos->add($programaFormativo);
            $programaFormativo->addActivFormativProduc($this);
        }

        return $this;
    }

    public function removeProgramaFormativo(ProgramaFormativo $programaFormativo): static
    {
        if ($this->programaFormativos->removeElement($programaFormativo)) {
            $programaFormativo->removeActivFormativProduc($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, criterioEvaluacion>
     */
    public function getCiterios(): Collection
    {
        return $this->citerios;
    }

    public function addCiterio(criterioEvaluacion $citerio): static
    {
        if (!$this->citerios->contains($citerio)) {
            $this->citerios->add($citerio);
        }

        return $this;
    }

    public function removeCiterio(criterioEvaluacion $citerio): static
    {
        $this->citerios->removeElement($citerio);

        return $this;
    }
}
