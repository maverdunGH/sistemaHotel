<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReseñaController extends AbstractController
{
    #[Route('/resenia', name: 'resenia_hotel')]
    public function mostrarPantalla(): Response
    {
        return $this->render('user/resenia.html.twig');
    }
}