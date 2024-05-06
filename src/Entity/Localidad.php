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
    private Collection $empresas;

    public function __construct()
    {
        $this->centroTrabajos = new ArrayCollection();
        $this->empresas = new ArrayCollection();
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

    public function addCentroTrabajo(CentroTrabajo $centroTrabajo): static
    {
        if (!$this->centroTrabajos->contains($centroTrabajo)) {
            $this->centroTrabajos->add($centroTrabajo);
            $centroTrabajo->setLocalid($this);
        }

        return $this;
    }

    public function removeCentroTrabajo(CentroTrabajo $centroTrabajo): static
    {
        if ($this->centroTrabajos->removeElement($centroTrabajo)) {
            // set the owning side to null (unless already changed)
            if ($centroTrabajo->getLocalid() === $this) {
                $centroTrabajo->setLocalid(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Empresa>
     */
    public function getEmpresas(): Collection
    {
        return $this->empresas;
    }

    public function addEmpresa(Empresa $empresa): static
    {
        if (!$this->empresas->contains($empresa)) {
            $this->empresas->add($empresa);
            $empresa->setLocalid($this);
        }

        return $this;
    }

    public function removeEmpresa(Empresa $empresa): static
    {
        if ($this->empresas->removeElement($empresa)) {
            // set the owning side to null (unless already changed)
            if ($empresa->getLocalid() === $this) {
                $empresa->setLocalid(null);
            }
        }

        return $this;
    }
}
