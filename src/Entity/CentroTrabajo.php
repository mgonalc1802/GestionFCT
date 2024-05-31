<?php

namespace App\Entity;

use App\Repository\CentroTrabajoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CentroTrabajoRepository::class)]
class CentroTrabajo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $direccion = null;

    #[ORM\Column(length: 9)]
    private ?string $telefono = null;

    #[ORM\Column(nullable: true)]
    private ?int $fax = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'centroTrabajos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Localidad $localid = null;

    /**
     * @var Collection<int, Empresa>
     */
    #[ORM\ManyToMany(targetEntity: Empresa::class, mappedBy: 'centros')]
    private Collection $Empresas;

    /**
     * @var Collection<int, Convenio>
     */
    #[ORM\OneToMany(targetEntity: Convenio::class, mappedBy: 'centroTrab')]
    private Collection $convenios;

    public function __construct()
    {
        $this->Empresas = new ArrayCollection();
        $this->convenios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): static
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getFax(): ?int
    {
        return $this->fax;
    }

    public function setFax(int $fax): static
    {
        $this->fax = $fax;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getLocalid(): ?Localidad
    {
        return $this->localid;
    }

    public function setLocalid(?Localidad $localid): static
    {
        $this->localid = $localid;

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
            $Empresa->addCentro($this);
        }

        return $this;
    }

    public function removeEmpresa(Empresa $Empresa): static
    {
        if ($this->Empresas->removeElement($Empresa)) {
            $Empresa->removeCentro($this);
        }

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
            $convenio->setCentroTrab($this);
        }

        return $this;
    }

    public function removeConvenio(Convenio $convenio): static
    {
        if ($this->convenios->removeElement($convenio)) {
            // set the owning side to null (unless already changed)
            if ($convenio->getCentroTrab() === $this) {
                $convenio->setCentroTrab(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->direccion . ' ->' . $this->getLocalid()->getNombre();
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'direccion' => $this->getDireccion(),
            'telefono' => $this->getTelefono(),
            'fax' => $this->getFax(),
            'localidad' => $this->getLocalid()->getNombre()
        ];
    }
}
