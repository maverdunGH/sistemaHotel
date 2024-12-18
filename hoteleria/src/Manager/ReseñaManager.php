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
        $reservasTotales = $this->obtenerReservas($usuario);
        $resenias = [];
        $fechaActual = new \DateTime();
        $fechaInicio = (clone $fechaActual)->modify('-14 days'); // LE SACO 14 DIAS A LA FECHA
        foreach($reservasTotales as $r){
            $fechaFinReserva = $r->getFechaFin();
            if($fechaActual >= $fechaFinReserva && $fechaFinReserva >= $fechaInicio){
                $habitacion = $r->getHabitacion();
                $hotel = $habitacion->getHotel();
                $reservaId = $r->getId();

                $comentarioResenia = $this->obtenerResenia($reservaId);

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
                        "reservaID"=>$reservaId,
                        "hotelID"=>$hotel->getId()
                    ];
                array_push($resenias,$objeto);
            }      
        }
        return $resenias;
    }
    private function obtenerReservas($usuario){
       return $this->repositoryReserva->findBy(['usuario'=>$usuario]);
    }

    private function obtenerHotelDesdeHabitacion($hotel){
        return $this->repositoryHotel->find($hotel);
    }
    private function obtenerHotel($hotel){
        return $this->repositoryHotel->findOneBy(['id'=>$hotel]);
    }
    private function obtenerHabitacion($habitacion){
        return $this->repositoryHabitacion->find($habitacion);
    }
    private function obtenerResenia($reserva){
        return $this->repositoryReseña->findOneBy(['reserva'=>$reserva]);
    }
    private function obtenerReserva($reserva){
        return $this->repositoryReserva->findOneBy(['id'=>$reserva]);
    }

    public function comentarHotel($usuario,$reserva,$hotelID,$comentario,$calificacion){
        $resenia = $this->obtenerResenia($reserva);
        $hotel = $this->obtenerHotel($hotelID);
        $reserva = $this->obtenerReserva($reserva);
        if($resenia == null){
            $resenia = new Resenia();
            $resenia->setHotel($hotel);
            $resenia->setReserva($reserva);
            $resenia->setComentario($comentario);
            $resenia->setCalificacion($calificacion);
        }else{
            $resenia->setComentario($comentario);
            $resenia->setCalificacion($calificacion);
        }
        $this->manager->persist($resenia);
        $this->manager->flush();
    }
}