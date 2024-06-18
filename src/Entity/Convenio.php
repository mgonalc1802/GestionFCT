<?php

namespace App\Entity;

use App\Repository\ConvenioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConvenioRepository::class)]
class Convenio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'convenios')]
    private ?CentroTrabajo $centroTrab = null;

    #[ORM\ManyToOne(inversedBy: 'convenios')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TutorLaboral $tutorLab = null;

    #[ORM\ManyToOne(inversedBy: 'convenios')]
    private ?ProgramaFormativo $programa = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'alumno')]
    private Collection $alumnos;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'profesor')]
    private Collection $users;

    #[ORM\Column(length: 255)]
    private ?string $pdf = null;

    public function __construct()
    {
        $this->alumnos = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCentroTrab(): ?CentroTrabajo
    {
        return $this->centroTrab;
    }

    public function setCentroTrab(?CentroTrabajo $centroTrab): static
    {
        $this->centroTrab = $centroTrab;

        return $this;
    }

    public function getTutorLab(): ?TutorLaboral
    {
        return $this->tutorLab;
    }

    public function setTutorLab(?TutorLaboral $tutorLab): static
    {
        $this->tutorLab = $tutorLab;

        return $this;
    }

    public function getPrograma(): ?ProgramaFormativo
    {
        return $this->programa;
    }

    public function setPrograma(?ProgramaFormativo $programa): static
    {
        $this->programa = $programa;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getAlumnos(): Collection
    {
        return $this->alumnos;
    }

    public function addAlumno(User $alumno): static
    {
        if (!$this->alumnos->contains($alumno)) {
            $this->alumnos->add($alumno);
            $alumno->setAlumno($this);
        }

        return $this;
    }

    public function removeAlumno(User $alumno): static
    {
        if ($this->alumnos->removeElement($alumno)) {
            // set the owning side to null (unless already changed)
            if ($alumno->getAlumno() === $this) {
                $alumno->setAlumno(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): User
    {
        return $this->users->first();
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addProfesor($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeProfesor($this);
        }

        return $this;
    }

    public function getPdf(): ?string
    {
        return $this->pdf;
    }

    public function setPdf(string $pdf): static
    {
        $this->pdf = $pdf;

        return $this;
    }
}
