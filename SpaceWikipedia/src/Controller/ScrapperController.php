<?php

namespace App\Controller;

use App\Service\FindUrls;
use App\Service\ScrapperWikipedia;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ScrapperController extends AbstractController
{
    #[Route('/scrapper', name: 'scrapper')]
    public function index(): Response
    {
        return $this->render('scrapper/index.html.twig', [
            'controller_name' => 'ScrapperController',
        ]);
    }

    #[Route('/scrapper/action', name: 'scrapperEnAction')]
    public function scrappeur(ScrapperWikipedia $scrapperWikipedia, FindUrls $urlManager, Request $request): Response
    {
        $nombre = $request->request->get('nombre');
        
        $scrapperWikipedia->scrapListe($urlManager->listeUrls($nombre));
        return $this->redirectToRoute("accueil");
    }
}
