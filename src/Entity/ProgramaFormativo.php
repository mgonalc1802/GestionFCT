<?php

namespace App\Entity;

use App\Repository\ProgramaFormativoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgramaFormativoRepository::class)]
class ProgramaFormativo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $resultadosAprendizaje = null;

    /**
     * @var Collection<int, Convenio>
     */
    #[ORM\OneToMany(targetEntity: Convenio::class, mappedBy: 'programa')]
    private Collection $convenios;

    /**
     * @var Collection<int, ActividadFormativoProductiva>
     */
    #[ORM\ManyToMany(targetEntity: ActividadFormativoProductiva::class, inversedBy: 'programaFormativos')]
    private Collection $activFormativProduc;

    public function __construct()
    {
        $this->convenios = new ArrayCollection();
        $this->activFormativProduc = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResultadosAprendizaje(): ?string
    {
        return $this->resultadosAprendizaje;
    }

    public function setResultadosAprendizaje(string $resultadosAprendizaje): static
    {
        $this->resultadosAprendizaje = $resultadosAprendizaje;

        return $this;
    }

    /**
     * @return Collection<int, Convenio>
     */
    public function getConvenios(): Collection
    {
        return $this->convenios;
    }

    public function addConvenio(Convenio $convenio): static
    {
        if (!$this->convenios->contains($convenio)) {
            $this->convenios->add($convenio);
            $convenio->setPrograma($this);
        }

        return $this;
    }

    public function removeConvenio(Convenio $convenio): static
    {
        if ($this->convenios->removeElement($convenio)) {
            // set the owning side to null (unless already changed)
            if ($convenio->getPrograma() === $this) {
                $convenio->setPrograma(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ActividadFormativoProductiva>
     */
    public function getActivFormativProduc(): Collection
    {
        return $this->activFormativProduc;
    }

    public function addActivFormativProduc(ActividadFormativoProductiva $activFormativProduc): static
    {
        if (!$this->activFormativProduc->contains($activFormativProduc)) {
            $this->activFormativProduc->add($activFormativProduc);
        }

        return $this;
    }

    public function removeActivFormativProduc(ActividadFormativoProductiva $activFormativProduc): static
    {
        $this->activFormativProduc->removeElement($activFormativProduc);

        return $this;
    }
}
