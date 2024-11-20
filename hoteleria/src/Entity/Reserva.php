<?php

namespace App\Entity;

use App\Repository\ReservaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservaRepository::class)]
class Reserva
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaInicio = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaFin = null;

    #[ORM\Column(length: 255)]
    private ?string $idHotel = null;

    #[ORM\OneToOne(inversedBy: 'reserva', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?habitacion $idHabitacion = null;

    #[ORM\OneToOne(inversedBy: 'reserva', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?usuario $idCliente = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(\DateTimeInterface $fechaInicio): static
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fechaFin;
    }

    public function setFechaFin(\DateTimeInterface $fechaFin): static
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    public function getIdHotel(): ?string
    {
        return $this->idHotel;
    }

    public function setIdHotel(string $idHotel): static
    {
        $this->idHotel = $idHotel;

        return $this;
    }

    public function getIdHabitacion(): ?habitacion
    {
        return $this->idHabitacion;
    }

    public function setIdHabitacion(habitacion $idHabitacion): static
    {
        $this->idHabitacion = $idHabitacion;

        return $this;
    }

    public function getIdCliente(): ?usuario
    {
        return $this->idCliente;
    }

    public function setIdCliente(usuario $idCliente): static
    {
        $this->idCliente = $idCliente;

        return $this;
    }
}
