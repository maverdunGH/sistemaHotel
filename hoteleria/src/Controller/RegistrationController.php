<?php
namespace App\Controller;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\UsuarioManager;

class RegistrationController extends AbstractController
{
#[Route('/register', name: 'app_register')]
    public function registrarse(): Response
    {
        return $this->render('security/register.html.twig');
    }

    #[Route('/register/crear', name: 'app_crear')]
    public function crearUsuario(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $manager): Response
    {
        $email = $request->request->get('_username');
        $plaintextPassword = $request->request->get('_password');

        $usuario = new Usuario();

        $hashedPassword = $passwordHasher->hashPassword($usuario, $plaintextPassword);

        $usuario->setEmail($email);
        $usuario->setPassword($hashedPassword);
        $manager->persist($usuario);
        $manager->flush();

        return $this->redirectToRoute('app_login');
    }
}
