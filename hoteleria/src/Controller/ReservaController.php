<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservaController extends AbstractController
{
    #[Route('/reserva_consultar', name: 'consultar_disponibilidad')]
    public function consultarDisponibilidad(): Response
    {
        return $this->render('user/disponibilidad.html.twig');
    }
    #[Route('/reserva_cancelar', name: 'cancelar_reserva')]
    public function cancelarReserva(): Response
    {
        return $this->render('user/cancelar-reserva.html.twig');
    }
}