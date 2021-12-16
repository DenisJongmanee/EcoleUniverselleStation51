<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\GetHTML;
use App\Service\TraitementLiens;
use App\Service\TraitementImages;
use App\Service\ScrapperWikipedia;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestesServiceGaetanController extends AbstractController
{
    #[Route('/testes/service/gaetan', name: 'testes_service_gaetan')]
    public function index(TraitementLiens $lienManager, ManagerRegistry $doctrine, ScrapperWikipedia $scrapper): Response
    {
        /*
        $liste = array('https://fr.wikipedia.org/wiki/Jean_Goffart', 'https://fr.wikipedia.org/wiki/Championnats_de_France_d%27athl%C3%A9tisme_1995', 'https://fr.wikipedia.org/wiki/Manfred_Reyes_Villa', 'https://fr.wikipedia.org/wiki/Papyrus_66', 'https://fr.wikipedia.org/wiki/Garner_Township_(Iowa)');

        $scrapper->scrapListe($liste);
        */
        $article = $doctrine->getRepository(Article::class)->find(7);
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
