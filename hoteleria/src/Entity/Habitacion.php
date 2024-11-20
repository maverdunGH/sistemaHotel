<?php

namespace App\Entity;

use App\Repository\HabitacionRepository;
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
    private ?hotel $idHotel = null;

    #[ORM\OneToOne(mappedBy: 'idHabitacion', cascade: ['persist', 'remove'])]
    private ?Reserva $reserva = null;

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

    public function getIdHotel(): ?hotel
    {
        return $this->idHotel;
    }

    public function setIdHotel(?hotel $idHotel): static
    {
        $this->idHotel = $idHotel;

        return $this;
    }

    public function getReserva(): ?Reserva
    {
        return $this->reserva;
    }

    public function setReserva(Reserva $reserva): static
    {
        // set the owning side of the relation if necessary
        if ($reserva->getIdHabitacion() !== $this) {
            $reserva->setIdHabitacion($this);
        }

        $this->reserva = $reserva;

        return $this;
    }
}
