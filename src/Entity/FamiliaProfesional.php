<?php

namespace App\Entity;

use App\Repository\FamiliaProfesionalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FamiliaProfesionalRepository::class)]
class FamiliaProfesional
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, Empresa>
     */
    #[ORM\OneToMany(targetEntity: Empresa::class, mappedBy: 'familiaProfesional')]
    private Collection $Empresa;

    public function __construct()
    {
        $this->Empresa = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Empresa>
     */
    public function getEmpresa(): Collection
    {
        return $this->Empresa;
    }

    public function addEmpresa(Empresa $Empresa): static
    {
        if (!$this->Empresa->contains($Empresa)) {
            $this->Empresa->add($Empresa);
            $Empresa->setFamiliaProfesional($this);
        }

        return $this;
    }

    public function removeEmpresa(Empresa $Empresa): static
    {
        if ($this->Empresa->removeElement($Empresa)) {
            // set the owning side to null (unless already changed)
            if ($Empresa->getFamiliaProfesional() === $this) {
                $Empresa->setFamiliaProfesional(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nombre;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre()
        ];
    }
}
