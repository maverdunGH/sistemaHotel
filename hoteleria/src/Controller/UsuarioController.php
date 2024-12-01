<?php
namespace App\Controller;
use App\Manager\UsuarioManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsuarioController extends AbstractController
{
    #[Route('/perfil', name: 'perfil_usuario')]
    public function mostrarPantallaPrincipal(UsuarioManager $usuarioManager): Response
    {
        $usuario = $usuarioManager->getUsuario($this->getUser());
        return $this->render('user/perfil.html.twig',['usuario'=>$usuario]);
    }

    #[Route('/perfil', name: 'perfil_modificar')]
    public function agregarProducto(Request $request,UsuarioManager $usuarioManager): Response
    {
        $nombre = $request->request->get('name');
        $telefono = $request->request->get('phone');
        $clave = $request->request->get('password');
        
        $ordenManager->modificarUsuario($this->getUser(),$nombre,$telefono,$clave);
        
        $this->addFlash('notice',"Los datos fueron modificados");
        //return $this->Response("<html><body> Nombre $nombre  Telefono $telefono</body></html>");
        return $this->redirectToRoute('perfil_usuario');
    }
}