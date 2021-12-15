<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\GetHTML;
use App\Service\TraitementLiens;
use App\Service\TraitementImages;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestesServiceGaetanController extends AbstractController
{
    #[Route('/testes/service/gaetan', name: 'testes_service_gaetan')]
    public function index(TraitementLiens $lienManager, ManagerRegistry $doctrine): Response
    {
        $article = $doctrine->getRepository(Article::class)->find(6);
        #$article = $lienManager->remplacementLiens($article);
        
        $contenu = $article->getHtml();

        return $this->render('testes_service_gaetan/index.html.twig', [
            'controller_name' => 'TestesServiceGaetanController',
            'contenu' => $contenu
        ]);
    }

    function testImage(GetHTML $source, TraitementImages $imageManager, ManagerRegistry $doctrine)
    {
        #$source->enregistrerArticle($source->getBody('https://fr.wikipedia.org/wiki/Rue_de_Tocqueville'));

        $article = $doctrine->getRepository(Article::class)->find(6);

        #$imageManager->trouveImages($article);
        #$imageManager->telechargeImagesArticle($article);

        $imageManager->ajoutCheminImagesLocale($article);

        $article = $doctrine->getRepository(Article::class)->find(6);
        $contenu = $article->getHtml();
        #dump($contenu);

        return $contenu;
    }
}
