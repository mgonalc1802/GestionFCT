<?php

namespace App\Entity;

use App\Repository\TutorLaboralRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TutorLaboralRepository::class)]
#[UniqueEntity(fields: ['dni'], message: 'Ya existe una cuenta con este dni.')]
class TutorLaboral
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 9, unique: true)]
    private ?string $dni = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $apellido1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $apellido2 = null;

    /**
     * @var Collection<int, Convenio>
     */
    #[ORM\OneToMany(targetEntity: Convenio::class, mappedBy: 'tutorLab')]
    private Collection $convenios;

    public function __construct()
    {
        $this->convenios = new ArrayCollection();
    }

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
            $convenio->setTutorLab($this);
        }

        return $this;
    }

    public function removeConvenio(Convenio $convenio): static
    {
        if ($this->convenios->removeElement($convenio)) {
            // set the owning side to null (unless already changed)
            if ($convenio->getTutorLab() === $this) {
                $convenio->setTutorLab(null);
            }
        }

        return $this;
    }
}
