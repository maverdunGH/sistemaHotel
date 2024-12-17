<?php

namespace App\Entity;

use App\Repository\ReseniaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReseniaRepository::class)]
class Resenia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $calificacion = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $comentario = null;

    #[ORM\OneToOne(inversedBy: 'resenia', cascade: ['persist', 'remove'])]
    private ?Reserva $relacion_reserva = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalificacion(): ?int
    {
        return $this->calificacion;
    }

    public function setCalificacion(int $calificacion): static
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): static
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getRelacionReserva(): ?Reserva
    {
        return $this->relacion_reserva;
    }

    public function setRelacionReserva(?Reserva $relacion_reserva): static
    {
        $this->relacion_reserva = $relacion_reserva;

        return $this;
    }
}
