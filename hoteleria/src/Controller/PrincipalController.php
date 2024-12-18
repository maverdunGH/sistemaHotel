<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrincipalController extends AbstractController
{
    #[Route('/', name: 'principal')]
    public function mostrarPantallaPrincipal(): Response
    {
        return $this->render('user/index.html.twig');
    }
    
    #[Route('/admin', name: 'menu_admin')]
    public function mostrarPantallaAdmin(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}