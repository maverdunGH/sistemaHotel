<?php

namespace App\Entity;

use App\Repository\HabitacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitacionRepository::class)]
class Habitacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\Column]
    private ?int $cantPersonas = null;

    #[ORM\Column]
    private ?float $precioNoche = null;

    #[ORM\ManyToOne(inversedBy: 'habitacion')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hotel $hotel = null;

    /**
     * @var Collection<int, Reserva>
     */
    #[ORM\OneToMany(targetEntity: Reserva::class, mappedBy: 'habitacion')]
    private Collection $reserva;

    public function __construct()
    {
        $this->reserva = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getCantPersonas(): ?int
    {
        return $this->cantPersonas;
    }

    public function setCantPersonas(int $cantPersonas): static
    {
        $this->cantPersonas = $cantPersonas;

        return $this;
    }

    public function getPrecioNoche(): ?float
    {
        return $this->precioNoche;
    }

    public function setPrecioNoche(float $precioNoche): static
    {
        $this->precioNoche = $precioNoche;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): static
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * @return Collection<int, Reserva>
     */
    public function getReserva(): Collection
    {
        return $this->reserva;
    }

    public function addReserva(Reserva $reserva): static
    {
        if (!$this->reserva->contains($reserva)) {
            $this->reserva->add($reserva);
            $reserva->setHabitacion($this);
        }

        return $this;
    }

    public function removeReserva(Reserva $reserva): static
    {
        if ($this->reserva->removeElement($reserva)) {
            // set the owning side to null (unless already changed)
            if ($reserva->getHabitacion() === $this) {
                $reserva->setHabitacion(null);
            }
        }

        return $this;
    }
}
