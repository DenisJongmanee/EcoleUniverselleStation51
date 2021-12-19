<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnexionController extends AbstractController
{
    #[Route('/connexion', name: 'connexion')]
    public function login()
    {
        return $this->render('connexion/index.html.twig');
        
    }

    #[Route('/deconnexion', name: 'deconnexion')]
    public function logout()
    {
        return $this->render('accueil/index.html.twig');
    }
}
