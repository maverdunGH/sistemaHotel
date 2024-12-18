<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Manager\HabitacionManager;
use App\Manager\HotelManager;

class HabitacionController extends AbstractController
{
    #[Route('/habitaciones/{hotel_id}', name: 'lista_habitaciones')]
    public function obtenerHabitaciones(HabitacionManager $habitacionManager, HotelManager $hotelManager, $hotel_id): Response
    {
        $habitaciones = $habitacionManager->obtenerHabitaciones($hotel_id);
        $hotel = $hotelManager->obtenerHotel($hotel_id);
        
        return $this->render('admin/gestionar_habitaciones.html.twig', [
            'habitaciones' => $habitaciones,
            'hotel' => $hotel
        ]);
    }

    #[Route('/habitaciones/agregar/{hotel_id}', name: 'agregar_habitacion')]
    public function agregarHabitacion(Request $request, HabitacionManager $habitacionManager, $hotel_id): Response
    {
        $numero = $request->request->get('numero');
        $cantPersonas = $request->request->get('cantPersonas');
        $precio = $request->request->get('precio');

        if (empty($numero) || empty($cantPersonas) || empty($precio)) {
            // Mensaje de error o redireccion
            $this->addFlash('notice',"¡Error, ningun campo debe estar vacio!");
            return $this->redirectToRoute('lista_habitaciones', ['hotel_id' => $hotel_id]);
        }

        if ($habitacionManager->encontrarHabitacion($numero, $hotel_id) == false){
            $this->addFlash('notice',"¡Error, el numero de habitacion ya existe!");
            return $this->redirectToRoute('lista_habitaciones', ['hotel_id' => $hotel_id]);
        }

        $habitacionManager->agregarHabitacion($numero, $cantPersonas, $precio, $hotel_id);

        $this->addFlash('notice',"Habitacion cargada satisfactoriamente");
        return $this->redirectToRoute('lista_habitaciones', ['hotel_id' => $hotel_id]);
    }

    #[Route('/habitacion/eliminar/{hotel_id}/{habitacion_id}', name: 'eliminar_habitacion')]
    public function eliminarHabitacion(HabitacionManager $habitacionManager, $habitacion_id, $hotel_id): Response
    {
        $habitacionManager->eliminarHabitacion($habitacion_id);

        $this->addFlash('notice',"Habitacion eliminada satisfactoriamente");
        return $this->redirectToRoute('lista_habitaciones',  ['hotel_id' => $hotel_id]);
    }

    #[Route('/hotel/ver/{hotel_id}/{habitacion_id}', name: 'ver_habitacion')]
    public function verInformacionHabitacion(HabitacionManager $habitacionManager, HotelManager $hotelManager, $habitacion_id, $hotel_id): Response
    {
        $habitacion = $habitacionManager->obtenerHabitacion($habitacion_id);
        $hotel = $hotelManager->obtenerHotel($hotel_id);

        return $this->render('admin/editar_habitacion.html.twig', [
            'habitacion' => $habitacion,
            'hotel' => $hotel
        ]);
    }

    #[Route('/habitacion/editar/{hotel_id}/{habitacion_id}', name: 'editar_habitacion', methods: ['POST'])]
    public function editarHabitacion(HabitacionManager $habitacionManager, Request $request, $habitacion_id, $hotel_id): Response
    {
        $numero = $request->request->get('numero');
        $cantPersonas = $request->request->get('cantPersonas');
        $precio = $request->request->get('precio');

        if (empty($numero) || empty($cantPersonas) || empty($precio)) {
            // Mensaje de error o redireccion
            $this->addFlash('notice',"¡Error, ningun campo debe estar vacio!");
            return $this->redirectToRoute('ver_habitacion', ['hotel_id' => $hotel_id, 'habitacion_id' => $habitacion_id]);
        }

        if ($habitacionManager->encontrarHabitacion($numero, $hotel_id) == false){
            $this->addFlash('notice',"¡Error, el numero de habitacion ya existe!");
            return $this->redirectToRoute('ver_habitacion', ['hotel_id' => $hotel_id, 'habitacion_id' => $habitacion_id]);
        }

        $habitacionManager->modificarHabitacion($habitacion_id, $numero, $cantPersonas , $precio);

        $this->addFlash('notice',"Habitacion modificada satisfactoriamente");
        return $this->redirectToRoute('lista_habitaciones',  ['hotel_id' => $hotel_id]);
    }
}
