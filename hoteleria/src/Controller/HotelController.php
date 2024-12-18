<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Manager\HotelManager;

class HotelController extends AbstractController
{
    #[Route('/hotel/ver', name: 'gestionar_publicacion')]
    public function verHoteles(HotelManager $hotelManager): Response
    {
        $usuario = $this->getUser();

        $hoteles = $hotelManager->obtenerHoteles($usuario->getId());
        return $this->render('admin/gestionar_publicacion.html.twig', ['hoteles' => $hoteles]);
    }

    #[Route('/hotel/agregar/', name: 'agregar_hotel', methods: ['POST'])]
    public function agregarHotel(HotelManager $hotelManager, Request $request): Response
    {
        $nombre = $request->request->get('nombre');
        $direccion = $request->request->get('direccion');
        $telefono = $request->request->get('telefono');
        $ciudad = $request->request->get('ciudad');
        $pais = $request->request->get('pais');
        $estrellas = $request->request->get('estrellas');
        $descripcion = $request->request->get('descripcion');
        $usuario = $this->getUser();

        if (empty($nombre) || empty($direccion) || empty($telefono) || empty($ciudad) || empty($pais) || empty($estrellas) || empty($descripcion)) {
            // Mensaje de error o redireccion
            $this->addFlash('notice',"¡Error, ningun campo debe estar vacio!");
            return $this->redirectToRoute('gestionar_publicacion');
        }

        $hotelManager->agregarHotel($nombre, $direccion , $telefono, $ciudad, $pais, $estrellas, $descripcion, $usuario->getId());

        $this->addFlash('notice',"Hotel cargado satisfactoriamente");
        return $this->redirectToRoute('gestionar_publicacion');
    }


    #[Route('/hotel/eliminar/{hotel_id}', name: 'eliminar_hotel')]
    public function eliminarHotel(HotelManager $hotelManager, $hotel_id): Response
    {
        $hotelManager->eliminarHotel($hotel_id);

        $this->addFlash('notice',"Hotel eliminado satisfactoriamente");
        return $this->redirectToRoute('gestionar_publicacion');
    }

    #[Route('/hotel/ver/{hotel_id}', name: 'ver_hotel')]
    public function verInformacionHotel(HotelManager $hotelManager, $hotel_id): Response
    {
        $hotel = $hotelManager->obtenerHotel($hotel_id);
        return $this->render('admin/editar_hotel.html.twig',['hotel' => $hotel]);
    }

    #[Route('/hotel/editar/{hotel_id}', name: 'editar_hotel', methods: ['POST'])]
    public function editarHotel(HotelManager $hotelManager, Request $request, $hotel_id): Response
    {
        $nombre = $request->request->get('nombre');
        $direccion = $request->request->get('direccion');
        $telefono = $request->request->get('telefono');
        $ciudad = $request->request->get('ciudad');
        $pais = $request->request->get('pais');
        $estrellas = $request->request->get('estrellas');
        $descripcion = $request->request->get('descripcion');

        if (empty($nombre) || empty($direccion) || empty($telefono) || empty($ciudad) || empty($pais) || empty($estrellas) || empty($descripcion)) {
            // Mensaje de error o redireccion
            $this->addFlash('notice',"¡Error, ningun campo debe estar vacio!");
            return $this->redirectToRoute('ver_hotel', ['hotel_id' => $hotel_id]);
        }

        $hotelManager->modificarHotel($hotel_id, $nombre, $direccion , $telefono, $ciudad, $pais, $estrellas, $descripcion);

        $this->addFlash('notice',"Hotel modificado satisfactoriamente");
        return $this->redirectToRoute('gestionar_publicacion');
    }

    #[Route('/historial_hoteles', name: 'historial_reservas_admin')]
    public function listarHoteles(HotelManager $hotelManager): Response
    {
        $usuario = $this->getUser();

        $hoteles = $hotelManager->obtenerHoteles($usuario->getId());
        return $this->render('admin/historial_reservas.html.twig', ['hoteles' => $hoteles]);
    }
}