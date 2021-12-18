<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\CleanArticle;
use App\Service\GetHTML;
use App\Service\TraitementLiens;
use App\Service\TraitementImages;
use App\Service\ScrapperWikipedia;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DomCrawler\Crawler;
use App\Service\GetCategorie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestesServiceGaetanController extends AbstractController
{
    #[Route('/testes/service/gaetan', name: 'testes_service_gaetan')]
    public function index(TraitementLiens $lienManager, ManagerRegistry $doctrine, ScrapperWikipedia $scrapper): Response
    {
        $article = $doctrine->getRepository(Article::class)->find(6);
        #$article = $lienManager->remplacementLiens($article);

        #$imageManager->trouveImages($article);
        #$imageManager->telechargeImagesArticle($article);
        
        $liste = array('https://fr.wikipedia.org/wiki/Papyrus_66');
        $erreurListe = $scrapper->scrapListe($liste);

        #dump important : debug des erreurs
        dump($erreurListe);

        $article = $doctrine->getRepository(Article::class)->find(25);
        $contenu = $article->getHtml();

        return $this->render('testes_service_gaetan/index.html.twig', [
            'controller_name' => 'TestesServiceGaetanController',
            'contenu' => $contenu
        ]);
    }

    function testImage(GetHTML $source, CleanArticle $cleanArticle, TraitementImages $imageManager, ManagerRegistry $doctrine)
    {
        #$source->enregistrerArticle($source->getBody('https://fr.wikipedia.org/wiki/Rue_de_Tocqueville'));
        $article = $doctrine->getRepository(Article::class)->find(6);
        
        // $categorieManager = new GetCategorie($doctrine, $article);
        // $categorieManager->ajoutCategories();
        // $cleanManager->cleanText($article);
        // $cleanManager->addCss($article);
        

        $imageManager->ajoutCheminImagesLocale($article);

        $article = $doctrine->getRepository(Article::class)->find(6);
        $contenu = $article->getHtml();
        #dump($contenu);

        return $contenu;
    }
}
