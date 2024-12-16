<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Manager\ReservaManager;

class ReservaController extends AbstractController
{
    #[Route('/reserva_consultar', name: 'consultar_disponibilidad')]
    public function consultarDisponibilidad(Request $request, ReservaManager $reservaManager): Response
    {
        $pais = $request->request->get('pais');
        $ciudad = $request->request->get('ciudad');
        $cantPersonas = $request->request->get('cantPersonas');
        $fechaDesde = $request->request->get('fechaDesde');
        $fechaHasta = $request->request->get('fechaHasta');

        $resultado = $reservaManager->consultarDisponibilidad($this->getUser(), $pais, $ciudad, $fechaDesde, $fechaHasta, $cantPersonas);
        if($resultado == null){
            $this->addFlash('notice',"Ya posee reserva en ese rango de fecha");
        }
        return $this->render('user/reserva.html.twig',['resultado'=>$resultado]);
    }
    #[Route('/reserva_realizadas', name: 'mis_reservas')]
    public function verMiReserva(ReservaManager $reservaManager): Response
    {
        $misReservas = $reservaManager->consultarMisReservas($this->getUser());

        return $this->render('user/reservas_usuario.html.twig',['misReservas'=>$misReservas]);
    }

    #[Route('/reserva_realizada', name: 'cancelar_reserva')]
    public function cancelarReserva(ReservaManager $reservaManager): Response
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