<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Manager\ReseñaManager;
use Symfony\Component\HttpFoundation\Request;

class ReseñaController extends AbstractController
{
    #[Route('/resenia', name: 'resenia_hotel')]
    public function comentarHoteles(ReseñaManager $reseñaManager): Response
    {
        $hotel = $reseñaManager->getReservas($this->getUser());

        return $this->render('user/resenia.html.twig',['hotel'=>$hotel]);
    }
}