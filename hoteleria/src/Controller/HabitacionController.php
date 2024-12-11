<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HabitacionController extends AbstractController
{
    #[Route('/', name: 'habitacion')]
    public function mostrarHabitaciones(): Response
    {
        return $this->render('user/index.html.twig');
    }
}