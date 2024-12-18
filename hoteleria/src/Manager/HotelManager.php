<?php
namespace App\Manager;
use App\Repository\HotelRepository;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Hotel;

class HotelManager{
    private $repositoryHotel;
    private $manager;
    private $repositoryUsuario;

    public function __construct(EntityManagerInterface $manager, HotelRepository $repositoryHotel, UsuarioRepository $repositoryUsuario)
    {
        $this->manager = $manager;
        $this->repositoryHotel = $repositoryHotel;
        $this->repositoryUsuario = $repositoryUsuario;
    }
    
    public function obtenerHoteles($propietario_id)
    {
        return $this->repositoryHotel->findBy(['propietario' => $propietario_id]);
    }

    public function obtenerHotel($hotel_id){
        return $this->repositoryHotel->findOneBy(['id'=>$hotel_id]);
    }

    public function agregarHotel($nombre, $direccion, $telefono, $ciudad, $pais, $estrellas, $descripcion, $propietario_id)
    {
        // Convierto la id del propietario de int a tipo usuario, para poder guardarla en la entidad hotel
        $propietario = $this->repositoryUsuario->find($propietario_id);

        $hotel = new Hotel();

        $hotel->setNombre($nombre);
        $hotel->setDireccion($direccion);
        $hotel->setTelefono($telefono);
        $hotel->setCiudad($ciudad);
        $hotel->setPais($pais);
        $hotel->setCantEstrellas($estrellas);
        $hotel->setDescripcion($descripcion);
        $hotel->setPropietario($propietario);
        $hotel->setImagen('images/hotel2.jpg');

        $this->manager->persist($hotel);
        $this->manager->flush();
    }

    public function modificarHotel($hotel_id, $nombre, $direccion, $telefono, $ciudad, $pais, $estrellas, $descripcion){
        $hotel = $this->obtenerHotel($hotel_id);

        $hotel->setNombre($nombre);
        $hotel->setDireccion($direccion);
        $hotel->setTelefono($telefono);
        $hotel->setCiudad($ciudad);
        $hotel->setPais($pais);
        $hotel->setCantEstrellas($estrellas);
        $hotel->setDescripcion($descripcion);

        $this->manager->persist($hotel);
        $this->manager->flush();
    }

    public function eliminarHotel($hotel_id)
    {
        $hotel = $this->repositoryHotel->find($hotel_id);

        $this->manager->remove($hotel);
        $this->manager->flush();
    }

}