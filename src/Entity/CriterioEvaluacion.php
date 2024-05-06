<?php

namespace App\Entity;

use App\Repository\CriterioEvaluacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CriterioEvaluacionRepository::class)]
class CriterioEvaluacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    /**
     * @var Collection<int, ActividadFormativoProductiva>
     */
    #[ORM\ManyToMany(targetEntity: ActividadFormativoProductiva::class, mappedBy: 'citerios')]
    private Collection $actividadesForm;

    public function __construct()
    {
        $this->actividadesForm = new ArrayCollection();
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
     * @return Collection<int, ActividadFormativoProductiva>
     */
    public function getActividadesForm(): Collection
    {
        return $this->actividadesForm;
    }

    public function addActividadesForm(ActividadFormativoProductiva $actividadesForm): static
    {
        if (!$this->actividadesForm->contains($actividadesForm)) {
            $this->actividadesForm->add($actividadesForm);
            $actividadesForm->addCiterio($this);
        }

        return $this;
    }

    public function removeActividadesForm(ActividadFormativoProductiva $actividadesForm): static
    {
        if ($this->actividadesForm->removeElement($actividadesForm)) {
            $actividadesForm->removeCiterio($this);
        }

        return $this;
    }
}
