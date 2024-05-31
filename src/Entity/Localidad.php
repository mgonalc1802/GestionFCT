<?php

namespace App\Entity;

use App\Repository\LocalidadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocalidadRepository::class)]
class Localidad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $codigoPostal = [];

    #[ORM\ManyToOne(inversedBy: 'localidades')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Provincia $provi = null;

    /**
     * @var Collection<int, CentroTrabajo>
     */
    #[ORM\OneToMany(targetEntity: CentroTrabajo::class, mappedBy: 'localid')]
    private Collection $centroTrabajos;

    /**
     * @var Collection<int, Empresa>
     */
    #[ORM\OneToMany(targetEntity: Empresa::class, mappedBy: 'localid')]
    private Collection $Empresas;

    public function __construct()
    {
        $this->centroTrabajos = new ArrayCollection();
        $this->Empresas = new ArrayCollection();
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

    public function getCodigoPostal(): array
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal(array $codigoPostal): static
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    public function getProvi(): ?Provincia
    {
        return $this->provi;
    }

    public function setProvi(?Provincia $provi): static
    {
        $this->provi = $provi;

        return $this;
    }

    /**
     * @return Collection<int, CentroTrabajo>
     */
    public function getCentroTrabajos(): Collection
    {
        return $this->centroTrabajos;
    }

    public function addCentroTrabajo(CentroTrabajo $CentroTrabajo): static
    {
        if (!$this->centroTrabajos->contains($CentroTrabajo)) {
            $this->centroTrabajos->add($CentroTrabajo);
            $CentroTrabajo->setLocalid($this);
        }

        return $this;
    }

    public function removeCentroTrabajo(CentroTrabajo $CentroTrabajo): static
    {
        if ($this->centroTrabajos->removeElement($CentroTrabajo)) {
            // set the owning side to null (unless already changed)
            if ($CentroTrabajo->getLocalid() === $this) {
                $CentroTrabajo->setLocalid(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Empresa>
     */
    public function getEmpresas(): Collection
    {
        return $this->Empresas;
    }

    public function addEmpresa(Empresa $Empresa): static
    {
        if (!$this->Empresas->contains($Empresa)) {
            $this->Empresas->add($Empresa);
            $Empresa->setLocalid($this);
        }

        return $this;
    }

    public function removeEmpresa(Empresa $Empresa): static
    {
        if ($this->Empresas->removeElement($Empresa)) {
            // set the owning side to null (unless already changed)
            if ($Empresa->getLocalid() === $this) {
                $Empresa->setLocalid(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'codigoPostal' => $this->getCodigoPostal(),
            'provincia' => $this->getProvi()->getNombre()
        ];
    }

    public function __toString()
    {
        return $this->nombre;
    }
}
