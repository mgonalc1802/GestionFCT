<?php

namespace App\Entity;

use App\Repository\EmpresaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpresaRepository::class)]
class Empresa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 9)]
    private ?string $nif = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $domicilioSocial = null;

    #[ORM\Column(length: 9)]
    private ?string $telefono = null;

    #[ORM\Column(nullable: true)]
    private ?int $fax = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $actividad = null;

    #[ORM\Column(length: 255)]
    private ?string $tutorDocente = null;

    /**
     * @var Collection<int, CentroTrabajo>
     */
    #[ORM\ManyToMany(targetEntity: CentroTrabajo::class, inversedBy: 'Empresas')]
    private Collection $centros;

    #[ORM\ManyToOne(inversedBy: 'Empresas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Localidad $localid = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?TutorLaboral $tutorLab = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Representante $repres = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?PersonaContacto $personaCont = null;

    #[ORM\ManyToOne(inversedBy: 'Empresa')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FamiliaProfesional $familiaProfesional = null;

    public function __construct()
    {
        $this->centros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNif(): ?string
    {
        return $this->nif;
    }

    public function setNif(string $nif): static
    {
        $this->nif = $nif;

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

    public function getDomicilioSocial(): ?string
    {
        return $this->domicilioSocial;
    }

    public function setDomicilioSocial(string $domicilioSocial): static
    {
        $this->domicilioSocial = $domicilioSocial;

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

    public function setFax(?int $fax): static
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

    public function getActividad(): ?string
    {
        return $this->actividad;
    }

    public function setActividad(string $actividad): static
    {
        $this->actividad = $actividad;

        return $this;
    }

    public function getTutorDocente(): ?string
    {
        return $this->tutorDocente;
    }

    public function setTutorDocente(string $tutorDocente): static
    {
        $this->tutorDocente = $tutorDocente;

        return $this;
    }

    /**
     * @return Collection<int, CentroTrabajo>
     */
    public function getCentros(): Collection
    {
        return $this->centros;
    }

    public function addCentro(CentroTrabajo $centro): static
    {
        if (!$this->centros->contains($centro)) 
        {
            $this->centros->add($centro);
        }

        return $this;
    }

    public function removeCentro(CentroTrabajo $centro): static
    {
        $this->centros->removeElement($centro);

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

    public function getTutorLab(): ?TutorLaboral
    {
        return $this->tutorLab;
    }

    public function setTutorLab(TutorLaboral $tutorLab): static
    {
        $this->tutorLab = $tutorLab;

        return $this;
    }

    public function getRepres(): ?Representante
    {
        return $this->repres;
    }

    public function setRepres(Representante $repres): static
    {
        $this->repres = $repres;

        return $this;
    }

    public function getPersonaCont(): ?PersonaContacto
    {
        return $this->personaCont;
    }

    public function setPersonaCont(PersonaContacto $personaCont): static
    {
        $this->personaCont = $personaCont;

        return $this;
    }

    public function getFamiliaProfesional(): ?FamiliaProfesional
    {
        return $this->familiaProfesional;
    }

    public function setFamiliaProfesional(?FamiliaProfesional $familiaProfesional): static
    {
        $this->familiaProfesional = $familiaProfesional;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'nif' => $this->getNif(),
            'nombre' => $this->getNombre(),
            'domicilioSocial' => $this->getDomicilioSocial(),
            'telefono' => $this->getTelefono(),
            'email' => $this->getEmail(),
            'actividad' => $this->getActividad(),
            'tutorDocente' => $this->getTutorDocente(),
            'tutorLaboral' => $this->getTutorLab()->jsonSerialize(),
            'centros' => $this->serializeCollection($this->getCentros()),
            'representante' => $this->getRepres()->jsonSerialize(),
            'personaContacto' => $this->getPersonaCont()->jsonSerialize(),
            'familiaProfesional' => $this->getFamiliaProfesional()
        ];
    }


    /**
     * Serializa una colección a un array.
     */
    public function serializeCollection($collection)
    {
        return array_map(function ($item) {
            return $item->jsonSerialize();
        }, $collection->toArray());
    }
}
