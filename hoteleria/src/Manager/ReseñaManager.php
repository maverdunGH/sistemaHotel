<?php
namespace App\Manager;
use App\Repository\ReseaRepository;
use App\Repository\HotelRepository;
use App\Repository\ReservaRepository;
use App\Repository\HabitacionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Resenia;
use App\Entity\Hotel;
use App\Entity\Reserva;
use App\Entity\Habitacion;

class ReseñaManager{
    private $repositoryReseña;
    private $repositoryHotel;
    private $repositoryReserva;
    private $repositoryHabitacion;
    private $manager;

    public function __construct(EntityManagerInterface $manager, ReseaRepository $repositoryReseña, HotelRepository $repositoryHotel,
        ReservaRepository $repositoryReserva, HabitacionRepository $repositoryHabitacion)
    {
        $this->manager = $manager;
        $this->repositoryReseña = $repositoryReseña;
        $this->repositoryHotel = $repositoryHotel;
        $this->repositoryReserva = $repositoryReserva;
        $this->repositoryHabitacion = $repositoryHabitacion;
    }
    public function getReservas($usuario): array
    {
        $reservasTotales = $this->repositoryReserva->findBy('id_cliente_id'=>$usuario);
        $resenias = [];
        $fechaFin = new \DateTime();
        $fechaInicio = (clone $fechaFin)->modify('-14 days'); // LE SACO 14 DIAS A LA FECHA
        foreach($reservasTotales as $r){
            $fechaFinReserva = $r->getFechaFin();
            if($fechaFin <= $fechaFinReserva && $fechaFinReserva >= $fechaInicio){
                $comentarioResenia = $this->repositoryReseña->findBy('relacion_reserva_id'=>$r.getId());
                
                $objeto = [
                    (object) ["comentario"=>null,
                        "descripcion"=>"Prueba descripcion"]
                    ];
            }
        }
        return $item;
    }
    private function getHotel($hotel){
        return $this->repositoryHotel->find($hotel);
    }
    private function getHabitacion($habitacion){
        return $this->repositoryHotel->find($hotel);
    }
    private function getResenia($resenia){
        return $this->repositoryHotel->findBy($resenia);
    }
}