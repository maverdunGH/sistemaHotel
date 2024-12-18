<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Manager\ReservaManager;

class ReservaController extends AbstractController
{
    #[Route('/reserva_consultar', name: 'filtros')]
    public function verFiltros(): Response
    {
        return $this->render('user/disponibilidad.html.twig');
    }

    #[Route('/reserva_consultar/disponibilidad', name: 'consultar_disponibilidad')]
    public function consultarDisponibilidad(Request $request, ReservaManager $reservaManager): Response
    {
        $pais = $request->request->get('country');
        $ciudad = $request->request->get('city');
        $cantPersonas = $request->request->get('guests');
        $fechaDesdeString = $request->request->get('check-in');
        $fechaHastaString = $request->request->get('check-out');

        $fechaDesde = new \DateTime($fechaDesdeString);
        $fechaHasta = new \DateTime($fechaHastaString);
        
/*      $fecha = new \DateTime();
        $resultado = (object)[
            "pais"=>$pais,
            "ciudad"=>$ciudad,
            "cantPersonas"=>$cantPersonas,
            "fechaDesdeString"=>$fechaDesdeString,
            "fechaHastaString"=>$fechaHastaString,
            "fechaActual"=>$fecha
        ];
        return $this->render('prueba.html.twig',['resultado'=>$resultado]);
        */
        $resultado = $reservaManager->consultarDisponibilidad($this->getUser(), $pais, $ciudad, $fechaDesde, $fechaHasta, $cantPersonas);
        if($resultado == null){
            $this->addFlash('notice',"Ya posee reserva en ese rango de fecha");
            return $this->render('user/reservar.html.twig',['resultado'=>null,'filtro'=>null]);
        }else{
            $filtro = (object)[
                'guests'=>$cantPersonas,
                'fechaDesde'=>$fechaDesdeString,
                'fechaHasta'=>$fechaHastaString
            ];
            return $this->render('user/reservar.html.twig',['resultado'=>$resultado,'filtro'=>$filtro]);
        }
    }

    #[Route('/reserva_consultar/disponibilidad/habitaciones', name: 'consultar_habitaciones')]
    public function mostrarHabitaciones(Request $request, ReservaManager $reservaManager): Response
    {
        $hotel = $request->request->get('idHotel');
        $cantPersonas = $request->request->get('cantPersonas');
        $fechaDesdeString = $request->request->get('fechaDesde');
        $fechaHastaString = $request->request->get('fechaHasta');
        
        $fechaDesde = new \DateTime($fechaDesdeString);
        $fechaHasta = new \DateTime($fechaHastaString);
        
        $habitaciones = $reservaManager->mostrarHabitaciones($hotel, $fechaDesde, $fechaHasta, $cantPersonas);
        $filtro = (object)[
            'cantPersonas'=>$cantPersonas,
            'fechaDesde'=>$fechaDesdeString,
            'fechaHasta'=>$fechaHastaString
        ];
        return $this->render('user/habitaciones.html.twig',['habitaciones'=>$habitaciones,'filtro'=>$filtro]);
        
        //return $this->render('prueba.html.twig',['filtro'=>$filtro]);
    }

    #[Route('/reserva_consultar/disponibilidad/habitaciones/reservar', name: 'reservar_habitacion')]
    public function reservarHabitacion(Request $request, ReservaManager $reservaManager): Response
    {
        $idHabitacion = $request->request->get('idHabitacion');
        $fechaDesdeString = $request->request->get('fechaDesde');
        $fechaHastaString = $request->request->get('fechaHasta');
        
        $fechaDesde = new \DateTime($fechaDesdeString);
        $fechaHasta = new \DateTime($fechaHastaString);

        $reservaManager->reservarHabitacion($this->getUser(), $idHabitacion, $fechaDesde, $fechaHasta);

        $this->addFlash('notice',"Reservacion exitosa");

        return $this->redirectToRoute('principal');
/*        $filtro = (object)[
            'idHabitacion'=>$idHabitacion,
            'fechaDesde'=>$fechaDesdeString,
            'fechaHasta'=>$fechaHastaString
        ];
        return $this->render('templates/prueba.html.twig',['filtro'=>$filtro]);
*/        
    }

    #[Route('/reserva_realizada', name: 'mis_reservas')]
    public function verMiReserva(ReservaManager $reservaManager): Response
    {
        $misReservas = $reservaManager->consultarMisReservas($this->getUser());

        return $this->render('user/reservas_usuario.html.twig',['misReservas'=>$misReservas]);
    }

    #[Route('/reserva_realizada', name: 'cancelar_reserva')]
    public function cancelarReserva(ReservaManager $reservaManager, ): Response
    {
        $resultado = $reservaManager->cancelarReserva($reserva);

        if($resultado){
            $this->addFlash('notice',"Reserva cancelada");
        }else{
            $this->addFlash('notice',"No se puede cancelar la reserva");
        }

        return $this->redirectToRoute('mis_reservas');
    }
}