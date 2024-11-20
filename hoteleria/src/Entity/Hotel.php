<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HotelRepository::class)]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nombre = null;

    #[ORM\Column(length: 100)]
    private ?string $direccion = null;

    #[ORM\Column(length: 100)]
    private ?string $telefono = null;

    #[ORM\Column(length: 50)]
    private ?string $pais = null;

    #[ORM\Column(length: 50)]
    private ?string $ciudad = null;

    #[ORM\Column]
    private ?int $cantEstrellas = null;

    /**
     * @var Collection<int, Habitacion>
     */
    #[ORM\OneToMany(targetEntity: Habitacion::class, mappedBy: 'idHotel')]
    private Collection $habitacion;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descripcion = null;

    public function __construct()
    {
        $this->habitacion = new ArrayCollection();
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

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public function setPais(string $pais): static
    {
        $this->pais = $pais;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): static
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getCantEstrellas(): ?int
    {
        return $this->cantEstrellas;
    }

    public function setCantEstrellas(int $cantEstrellas): static
    {
        $this->cantEstrellas = $cantEstrellas;

        return $this;
    }

    /**
     * @return Collection<int, Habitacion>
     */
    public function getHabitacion(): Collection
    {
        return $this->habitacion;
    }

    public function addHabitacion(Habitacion $habitacion): static
    {
        if (!$this->habitacion->contains($habitacion)) {
            $this->habitacion->add($habitacion);
            $habitacion->setIdHotel($this);
        }

        return $this;
    }

    public function removeHabitacion(Habitacion $habitacion): static
    {
        if ($this->habitacion->removeElement($habitacion)) {
            // set the owning side to null (unless already changed)
            if ($habitacion->getIdHotel() === $this) {
                $habitacion->setIdHotel(null);
            }
        }

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}
