<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DomCrawler\Crawler;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Article;


class GetHTML
{
    private $client;
    private $doctrine;
    private $validator;

    public function __construct(HttpClientInterface $client, ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
        $this->client = $client;
        $this->doctrine = $doctrine;
        $this->validator = $validator;
    }

    public function getBody($url)
    {
        $reponse = $this->client->request('GET', $url);
        $html = $reponse->getContent();
        $crawler = new Crawler($html);
        $contenu = $crawler->filter('#bodyContent')->html();

        return $contenu;
    }

    public function enregistrerArticle($html, $titre = "")
    {
        
        $article = new Article;
        $article->setHtml($html);
        $article->setTitre($titre);

        $erreurs = $this->validator->validate($article);
        if (count($erreurs) == 0) {

            $manager = $this->doctrine->getManager();
            $manager->persist($article);
            $manager->flush();
            
        } else {
            dump(array("erreurs enregistrement article" => $erreurs));
        }

        
    }
}