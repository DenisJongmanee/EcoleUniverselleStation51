<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RessourcesController extends AbstractController
{
    #[Route('/ressources', name: 'ressources')]
    public function list(ManagerRegistry $doctrine): Response
    {

        $manager = $doctrine->getManager();

        $repositoryArticle = $manager->getRepository(Article::class);
        
        $articles = $repositoryArticle->findAll();
        
        dump($articles);

        return $this->render('ressources/index.html.twig', [
            'articles' => $articles
        ]);
    }
}
