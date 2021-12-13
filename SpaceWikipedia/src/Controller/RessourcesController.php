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
    #[Route('/ressources', name: 'listRessources')]
    public function list(ManagerRegistry $doctrine, Request $request): Response
    {
        #redirection vers l'accueil si le critère n'est pas défini
        if (!$request->query->get('search')) 
        {
            return $this->redirectToRoute('accueil');
        }

        #on récupère le critère du champ
        $title = $request->query->get('search');
        
        $repositoryArticle = new ArticleRepository($doctrine);
        
        $articles = $repositoryArticle->findAllByTitle($title);

        dump($articles);

        return $this->render('ressources/index.html.twig', [
            'articles' => $articles,
            'search' => $title
        ]);
    }

    #[Route('/ressources/{id}', name:"itemRessource")]
    public function item(ManagerRegistry $doctrine, int $id) : Response
    {
       
        $entityManager = $doctrine->getManager();
        $repositoryArticle = $entityManager->getRepository(Article::class);
        $article = $repositoryArticle->find($id);
        dump($article);
        return $this->render('ressources/item.html.twig', [
            "article" => $article
        ]);
    }
}
