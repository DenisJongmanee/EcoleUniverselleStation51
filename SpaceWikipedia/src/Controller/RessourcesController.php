<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;

class RessourcesController extends AbstractController
{
    #[Route('/ressources', name: 'ressources')]
    public function list(ManagerRegistry $doctrine, Request $request): Response
    {
        if (!$request->query->get('search')) 
        {
            return $this->redirectToRoute('accueil');
        }

        $title = $request->query->get('search');
        
        $repositoryArticle = new ArticleRepository($doctrine);
        
        $articles = $repositoryArticle->findAllByTitle($title);
        
        dump($articles);

        return $this->render('ressources/index.html.twig', [
            'articles' => $articles,
            'search' => $title
        ]);
    }
}
