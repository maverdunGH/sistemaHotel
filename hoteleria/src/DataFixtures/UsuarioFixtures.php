<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Usuario;

class UsuarioFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 5; $i++){
            $usuario = new Usuario();
            //$usuario->setNombre('usuario'.$i);
            $usuario->setEmail('usuario'.$i.'@gmail.com');
            $usuario->setPassword('$2y$13$wONoq0FYf0J6iKtiskpYdu3sZ.wSg8PUFTXIQgYTc/tfXXNnpAjhe');
            $manager->persist($usuario);
            }

        $manager->flush();
    }
}
