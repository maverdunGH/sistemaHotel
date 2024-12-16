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
        $reservasUsuario = $this->buscarReservas($usuario);
        if($reservasUsuario == null){
            return $this->buscarHoteles($pais, $ciudad, $fechaDesde, $fechaHasta, $cantPersonas);
        }if($buscarReservas($usuario)){
            return $this->buscarHoteles($pais, $ciudad, $fechaDesde, $fechaHasta, $cantPersonas);
        }else{
            return null;
        }
    }
    private function buscarReservas($usuario){
        $reservas = $this->repositoryReserva->findBy(['idCliente'=>$usuario]);
        $fechaActual = new \DateTime();
        foreach($reservas as $r){
            if($fechaActual >= $r->getFechaInicio() && $fechaActual <= $r->getFechaFin()){
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
                    $habitacion = [
                        'numero'=>$hab->getNumero()
                    ];
                }
                array_push($arrayDisponibilidad,$habitacion);
            }
            $hotel = [
                'nombre'=>$h->getNombre(),
                'direccion'=>$h->getDireccion(),
                'telefono'=>$h->getTelefono(),
                'estrellas'=>$h->getCantEstrellas(),
                'habitaciones'=>$arrayDisponibilidad
            ];
            array_push($arrayHotelesEcontrados,$hotel);
        }
        return $arrayHotelesEcontrados;
    }
    private function buscarHabitaciones($hotel, $cantPersonas){
        return $habitaciones = $this->findBy(['idHotel'=>$hotel, 'cantPersonas'=>$cantPersonas]);
    }
    private function buscarReservaHabitacion($habitacion, \DateTime $fechaDesde, \DateTime $fechaHasta){
        $reservas = $this->repositoryReserva->findBy(['idHabitacion'=>$habitacion]);
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
    public function agregarReserva($usuario, $habitacion, $fechaDesde, $fechaHasta){
        $reserva = new Reserva();
        $reserva->setIdCliente($usuario);
        $reserva->setIdHabitacion($habitacion);
        $reserva->setFechaInicio($fechaDesde);
        $reserva->setFechaFin($fechaHasta);
        $this->manager->persist($reserva);
        $this->manager->flush();
    }
    public function consultarMisReservas($usuario){
        return $this->repositoryReserva->findBy(['idCliente'=>$usuario]);
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
}