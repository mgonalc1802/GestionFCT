<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Ya existe una cuenta con este correo.')]
#[UniqueEntity(fields: ['dni'], message: 'Ya existe una cuenta con este dni.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 9, unique: true)]
    private ?string $dni = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $apellido1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $apellido2 = null;

    /**
     * @var Collection<int, periodo>
     */
    #[ORM\ManyToMany(targetEntity: Periodo::class, inversedBy: 'usuarios')]
    private Collection $periodos;

    #[ORM\ManyToOne(inversedBy: 'alumnos')]
    private ?Convenio $alumno = null;

    /**
     * @var Collection<int, Convenio>
     */
    #[ORM\ManyToMany(targetEntity: Convenio::class, inversedBy: 'users')]
    private Collection $profesor;

    #[ORM\ManyToOne(inversedBy: 'alumnos')]
    private ?CicloFormativo $cicloFormativo = null;

    public function __construct()
    {
        $this->periodos = new ArrayCollection();
        $this->profesor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
     * @return Collection<int, periodo>
     */
    public function getPeriodos(): Collection
    {
        return $this->periodos;
    }

    public function addPeriodo(Periodo $periodo): static
    {
        if (!$this->periodos->contains($periodo)) {
            $this->periodos->add($periodo);
        }

        return $this;
    }

    public function removePeriodo(Periodo $periodo): static
    {
        $this->periodos->removeElement($periodo);

        return $this;
    }

    public function getAlumno(): ?Convenio
    {
        return $this->alumno;
    }

    public function setAlumno(?Convenio $alumno): static
    {
        $this->alumno = $alumno;

        return $this;
    }

    /**
     * @return Collection<int, Convenio>
     */
    public function getProfesor(): Collection
    {
        return $this->profesor;
    }

    public function addProfesor(Convenio $profesor): static
    {
        if (!$this->profesor->contains($profesor)) {
            $this->profesor->add($profesor);
        }

        return $this;
    }

    public function removeProfesor(Convenio $profesor): static
    {
        $this->profesor->removeElement($profesor);

        return $this;
    }

    public function getCicloFormativo(): ?CicloFormativo
    {
        return $this->cicloFormativo;
    }

    public function setCicloFormativo(?CicloFormativo $cicloFormativo): static
    {
        $this->cicloFormativo = $cicloFormativo;

        return $this;
    }
}
