<?php
namespace App\Manager;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Usuario;

class UsuarioManager{
    private $repository;
    private $manager;

    public function __construct(EntityManagerInterface $manager,UsuarioRepository $repository){
        $this->repository = $repository;
        $this->manager = $manager;
    }
    public function getUsuario($usuario){
        return $this->repository->find($usuario);
    }
    public function modificarUsuario($usuario,$nombre,$telefono,$clave){
        $usuario = $this->getUsuario($usuario);
        $usuario->setNombre($nombre);
        $usuario->setTelefono($telefono);
        $this->manager->persist($usuario);
        $this->manager->flush();
    }
}