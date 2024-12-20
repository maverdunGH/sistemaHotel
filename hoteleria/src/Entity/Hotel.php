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

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\ManyToOne(inversedBy: 'hotel')]
    #[ORM\JoinColumn(nullable: false)]
    private ?usuario $propietario = null;

    /**
     * @var Collection<int, Habitacion>
     */
    #[ORM\OneToMany(targetEntity: Habitacion::class, mappedBy: 'hotel')]
    private Collection $habitacion;

    /**
     * @var Collection<int, Resenia>
     */
    #[ORM\OneToMany(targetEntity: Resenia::class, mappedBy: 'hotel')]
    private Collection $resenia;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagen = null;

    public function __construct()
    {
        $this->habitacion = new ArrayCollection();
        $this->resenia = new ArrayCollection();
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPropietario(): ?usuario
    {
        return $this->propietario;
    }

    public function setPropietario(?usuario $propietario): static
    {
        $this->propietario = $propietario;

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
            $habitacion->setHotel($this);
        }

        return $this;
    }

    public function removeHabitacion(Habitacion $habitacion): static
    {
        if ($this->habitacion->removeElement($habitacion)) {
            // set the owning side to null (unless already changed)
            if ($habitacion->getHotel() === $this) {
                $habitacion->setHotel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Resenia>
     */
    public function getResenia(): Collection
    {
        return $this->resenia;
    }

    public function addResenium(Resenia $resenium): static
    {
        if (!$this->resenia->contains($resenium)) {
            $this->resenia->add($resenium);
            $resenium->setHotel($this);
        }

        return $this;
    }

    public function removeResenium(Resenia $resenium): static
    {
        if ($this->resenia->removeElement($resenium)) {
            // set the owning side to null (unless already changed)
            if ($resenium->getHotel() === $this) {
                $resenium->setHotel(null);
            }
        }

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): static
    {
        $this->imagen = $imagen;

        return $this;
    }
}
