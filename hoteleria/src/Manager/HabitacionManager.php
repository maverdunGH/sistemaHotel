<?php
namespace App\Manager;
use App\Repository\HabitacionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\HotelRepository;
use App\Entity\Habitacion;

class HabitacionManager{
    private $repositoryHabitacion;
    private $manager;
    private $repositoryHotel;

    public function __construct(EntityManagerInterface $manager, HabitacionRepository $repositoryHabitacion, HotelRepository $repositoryHotel)
    {
        $this->manager = $manager;
        $this->repositoryHabitacion = $repositoryHabitacion;
        $this->repositoryHotel = $repositoryHotel;
    }
    
    public function obtenerHabitaciones($hotel_id)
    {
        return $this->repositoryHabitacion->findBy(['hotel' => $hotel_id]);
    }

    public function obtenerHabitacion($habitacion_id){
        return $this->repositoryHabitacion->findOneBy(['id'=>$habitacion_id]);
    }

    public function agregarHabitacion($numero, $cantPersonas, $precio, $hotel_id)
    {
        // Convierto la id del hotel de int a tipo hotel, para poder guardarla en la entidad habitacion
        $hotel = $this->repositoryHotel->find($hotel_id);
 
        $habitacion = new Habitacion();

        $habitacion->setNumero($numero);
        $habitacion->setCantPersonas($cantPersonas);
        $habitacion->setPrecioNoche($precio);
        $habitacion->setHotel($hotel);

        $this->manager->persist($habitacion);
        $this->manager->flush();
    }

    public function eliminarHabitacion($habitacion_id)
    {
        $habitacion = $this->repositoryHabitacion->find($habitacion_id);

        $this->manager->remove($habitacion);
        $this->manager->flush();
    }

    public function modificarHabitacion($habitacion_id, $numero, $cantPersonas, $precio){
        $habitacion = $this->obtenerHabitacion($habitacion_id);

        $habitacion->setNumero($numero);
        $habitacion->setCantPersonas($cantPersonas);
        $habitacion->setPrecioNoche($precio);

        $this->manager->persist($habitacion);
        $this->manager->flush();
    }

    public function encontrarHabitacion($numero, $hotel_id)
    {
        // Convierto la id del hotel de int a tipo hotel, para poder guardarla en la entidad habitacion
        $hotel = $this->repositoryHotel->find($hotel_id);
        
        $habitacionExistente = $this->repositoryHabitacion->findOneBy([
            'numero' => $numero,
            'hotel' => $hotel
        ]);

        if ($habitacionExistente != null){
            return false;
        } else {
            return true;
        }

    }

}