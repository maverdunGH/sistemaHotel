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

class ReservaManager{
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
    public function consultarDisponibilidad($usuario, $pais, $ciudad, $fechaDesde, $fechaHasta, $cantPersonas){
        $reservasUsuario = $this->buscarReservas($usuario, $fechaDesde, $fechaHasta);
        if($reservasUsuario){
            return $this->buscarHoteles($pais, $ciudad, $fechaDesde, $fechaHasta, $cantPersonas);
        }else{
            return null;
        }
    }
    //BUSCAR EN CASO DE QUE YA EXISTA UNA RESERVACION EN ESE RANGO DE FECHA
    private function buscarReservas($usuario, $fechaDesde, $fechaHasta){
        $reservas = $this->repositoryReserva->findBy(['usuario'=>$usuario]);
        foreach($reservas as $r){
            if($fechaDesde >= $r->getFechaInicio() && $fechaDesde <= $r->getFechaFin()){
                return false;
            }
            if($fechaHasta >= $r->getFechaInicio() && $fechaHasta <= $r->getFechaFin()){
                return false;
            }
        }
        return true;
    }
    private function buscarHoteles($pais, $ciudad, $fechaDesde, $fechaHasta, $cantPersonas){
        $arrayHotelesEcontrados = [];
        $hoteles = $this->repositoryHotel->findBy(['pais'=>$pais,'ciudad'=>$ciudad]);
        foreach($hoteles as $h){
            $arrayDisponibilidad = [];
            foreach($this->buscarHabitaciones($h, $cantPersonas) as $hab){
                if($this->buscarReservaHabitacion($hab, $fechaDesde, $fechaHasta)){
                    $habitacion = (object) [
                        'numero'=>$hab->getNumero()
                    ];
                    array_push($arrayDisponibilidad,$habitacion);
                }
            }
            $hotel = (object) [
                'id'=>$h->getId(),
                'nombre'=>$h->getNombre(),
                'direccion'=>$h->getDireccion(),
                'descripcion'=>$h->getDescripcion(),
                'telefono'=>$h->getTelefono(),
                'estrellas'=>$h->getCantEstrellas(),
                'habitaciones'=>$arrayDisponibilidad
            ];
            array_push($arrayHotelesEcontrados,$hotel);
        }
        return $arrayHotelesEcontrados;
    }
    private function buscarHabitaciones($hotel, $cantPersonas){
        return $habitaciones = $this->repositoryHabitacion->findBy(['hotel'=>$hotel, 'cantPersonas'=>$cantPersonas]);
    }
    private function buscarReservaHabitacion($habitacion, \DateTime $fechaDesde, \DateTime $fechaHasta){
        $reservas = $this->repositoryReserva->findBy(['habitacion'=>$habitacion]);
        foreach($reservas as $r){
            $fechaInicioReserva = $r->getFechaInicio();
            $fechaFinReserva = $r->getFechaFin();
            if($fechaDesde >= $fechaInicioReserva && $fechaDesde <= $fechaFinReserva){
               return false; 
            }
            if($fechaHasta >= $fechaInicioReserva && $fechaHasta <= $fechaFinReserva){
                return false;
            }
        }
        return true;
    }
    public function consultarMisReservas($usuario){
        return $this->repositoryReserva->findBy(['usuario'=>$usuario]);
    }
    public function cancelarReserva($reserva){
        $reserva = $this->repositoryReserva->find($reserva);
        $fechaActual = new \DateTime();
        if($fechaActual >= $reserva->getFechaInicio() && $fechaActual <= $reserva->getFechaFin()){
            return false;
        }else if($fechaActual > $reserva->getFechaFin){
            return false;
        }else{
            $this->manager->remove($reserva);
            $this->manager->flush();
            return true;
        }
    }
    public function mostrarHabitaciones($hotelID, $fechaDesde, $fechaHasta, $cantPersonas){
        $hotel = $this->obtenerHotel($hotelID);
        $arrayDisponibilidad = [];
        foreach($this->buscarHabitaciones($hotel, $cantPersonas) as $hab){
            if($this->buscarReservaHabitacion($hab, $fechaDesde, $fechaHasta)){
                $habitacion = [
                    'id'=>$hab->getId(),
                    'numero'=>$hab->getNumero(),
                    'cantPersonas'=>$hab->getCantPersonas(),
                    'precio'=>$hab->getPrecioNoche()
                ];
                array_push($arrayDisponibilidad,$habitacion);
            }
        }
        return $arrayDisponibilidad;
    }

    private function obtenerHotel($id){
        return $this->repositoryHotel->findOneBy(['id'=>$id]);    
    }

    private function obtenerHabitacion($id){
        return $this->repositoryHabitacion->findOneBy(['id'=>$id]);    
    }

    public function reservarHabitacion($usuario, $idHabitacion, \DateTime $fechaDesde, \DateTime $fechaHasta){
        $habitacion = $this->obtenerHabitacion($idHabitacion);
        $reserva = new Reserva();
        $reserva->setUsuario($usuario);
        $reserva->setHabitacion($habitacion);
        $reserva->setFechaInicio($fechaDesde);
        $reserva->setFechaFin($fechaHasta);
        $this->manager->persist($reserva);
        $this->manager->flush();
    }
}