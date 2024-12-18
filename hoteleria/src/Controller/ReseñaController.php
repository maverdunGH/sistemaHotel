<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Manager\ReseñaManager;

class ReseñaController extends AbstractController
{
    #[Route('/resenia', name: 'resenia_hotel')]
    public function buscarHoteles(ReseñaManager $reseñaManager): Response
    {
        $reseña = $reseñaManager->getReservas($this->getUser());

        return $this->render('user/resenia.html.twig',['reseña'=>$reseña]);
    }

    #[Route('/resenia/comentar', name: 'resenia_comentar')]
    public function comentarHoteles(ReseñaManager $reseñaManager, Request $request): Response
    {
        $reserva = $request->request->get('idReserva');
        $hotel = $request->request->get('idHotel');
        $comentario = $request->request->get('comment');
        $calificacion = $request->request->get('rating');

        if (empty($comentario) || empty($calificacion)) {
            $this->addFlash('notice',"Faltó ingresar algunos datos");
            return $this->redirectToRoute('resenia_hotel');
        }

        $reseñaManager->comentarHotel($this->getUser(),$reserva,$hotel,$comentario,$calificacion);

/*        $filtro = (object)[
            'idReserva'=>$reserva,
            'idHotel'=>$hotel,
            'comentario'=>$comentario,
            'calificacion'=>$calificacion
        ];
        return $this->render('prueba.html.twig',['filtro'=>$filtro]);
*/

        $this->addFlash('notice',"Se ingresó/modificó el comentario con exito");

        return $this->redirectToRoute('resenia_hotel');
        
    }
}