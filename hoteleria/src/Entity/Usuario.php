<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $clave = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(length: 150)]
    private ?string $nombre = null;

    #[ORM\Column(length: 150)]
    private ?string $apellido = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nacionalidad = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $direccion = null;

    #[ORM\Column(length: 2)]
    private ?string $tipo = null;

    #[ORM\OneToOne(mappedBy: 'idCliente', cascade: ['persist', 'remove'])]
    private ?Resenia $resenia = null;

    #[ORM\OneToOne(mappedBy: 'idCliente', cascade: ['persist', 'remove'])]
    private ?Reserva $reserva = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClave(): ?string
    {
        return $this->clave;
    }

    public function setClave(string $clave): static
    {
        $this->clave = $clave;

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

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): static
    {
        $this->telefono = $telefono;

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

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): static
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getNacionalidad(): ?string
    {
        return $this->nacionalidad;
    }

    public function setNacionalidad(?string $nacionalidad): static
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): static
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getResenia(): ?Resenia
    {
        return $this->resenia;
    }

    public function setResenia(Resenia $resenia): static
    {
        // set the owning side of the relation if necessary
        if ($resenia->getIdCliente() !== $this) {
            $resenia->setIdCliente($this);
        }

        $this->resenia = $resenia;

        return $this;
    }

    public function getReserva(): ?Reserva
    {
        return $this->reserva;
    }

    public function setReserva(Reserva $reserva): static
    {
        // set the owning side of the relation if necessary
        if ($reserva->getIdCliente() !== $this) {
            $reserva->setIdCliente($this);
        }

        $this->reserva = $reserva;

        return $this;
    }
}
