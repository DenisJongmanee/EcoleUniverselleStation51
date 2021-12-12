<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GetHTML;
use App\Service\TraitementImages;
use Symfony\Component\DomCrawler\Crawler;
use Doctrine\Persistence\ManagerRegistry;

class TestesServiceGaetanController extends AbstractController
{
    #[Route('/testes/service/gaetan', name: 'testes_service_gaetan')]
    public function index(GetHTML $source, TraitementImages $imageManager, ManagerRegistry $doctrine): Response
    {
        #$source->enregistrerArticle($source->getBody('https://fr.wikipedia.org/wiki/Micha%C5%82_Boni'));

        $article = $doctrine->getRepository(Article::class)->find(1);
        $imageManager->trouveImages($article);
        $contenu = $article->getHtml();
        dump($contenu);
        return $this->render('testes_service_gaetan/index.html.twig', [
            'controller_name' => 'TestesServiceGaetanController',
            'contenu' => $contenu
        ]);
    }
}
