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
    public function getReservas($usuario)
    {
        $reservasTotales = $this->repositoryReserva->findBy(['idCliente'=>$usuario]);
        $resenias = [];
        $fechaActual = new \DateTime();
        $fechaInicio = (clone $fechaActual)->modify('-14 days'); // LE SACO 14 DIAS A LA FECHA
        foreach($reservasTotales as $r){
            $fechaFinReserva = $r->getFechaFin();
            if($fechaActual <= $fechaFinReserva && $fechaFinReserva >= $fechaInicio){
                $habitacion = $this->repositoryHabitacion->find($r->getIdHabitacion());
                $hotel = $this->getHotel($habitacion->getIdHotel());
                $reservaId = $r->getId();
                $comentarioResenia = $this->getResenia($reservaId);

                $hotelDescripcion = $hotel->getDescripcion();
                $hotelEstrellas = $hotel->getCantEstrellas();
                $habitacionNro = $habitacion->getNumero();
                $comentario;
                if($comentarioResenia != null){
                    $comentario = $comentarioResenia->getComentario();
                }else{
                    $comentario = null;
                }
                $objeto = (object) ["hotel_descripcion"=>$hotelDescripcion,
                        "comentario"=>$comentario,
                        "cant_estrellas"=>$hotelEstrellas,
                        "reserva"=>$reservaId,
                        "hotel"=>$hotel->getId(),
                        "resenia"=>$comentarioResenia->getId()
                    ];
                array_push($resenias,$objeto);
            }      
        }
        return $resenias;
    }
    private function getHotel($hotel){
        return $this->repositoryHotel->find($hotel);
    }
    private function getHabitacion($habitacion){
        return $this->repositoryHotel->find($habitacion);
    }
    private function getResenia($reserva){
        return $this->repositoryReseña->findOneBy(['relacion_reserva'=>$reserva]);
    }
    public function comentarHotel($usuario,$reserva,$hotel,$comentario){
        $resenia = $this->getResenia($reserva);
        if($resenia == null){
            $resenia = new Resenia();
            $resenia->setHotel($hotel);
            $resenia->setReserva($reserva);
            $resenia->setIdCliente($usuario);
            $resenia->setComentario($comentario);
        }else{
            $resenia->setComentario($comentario);
        }
        $this->manager->persist($resenia);
        $this->manager->flush();
    }
}