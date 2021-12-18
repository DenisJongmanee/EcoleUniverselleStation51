<?php
namespace App\Service;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FindUrls
{
    private $urlAleatoire = 'https://fr.wikipedia.org/wiki/Sp%C3%A9cial:Page_au_hasard';

    private $client;
    private $doctrine;
    private $urls;


    public function __construct(HttpClientInterface $client, ManagerRegistry $doctrine)
    {
        $this->client = $client;
        $this->doctrine = $doctrine;
        $articles = $this->doctrine->getRepository(Article::class)->findAll();
        $this->urls = [];
        for ($i=0; $i < count($articles); $i++) { 
            array_push( $this->urls , $articles[$i]->getUrl() );
        }
    }

    public function listeUrls(int $nombre)
    {
        $liste = [];

        if ($nombre < 0)
        {
            return $liste;
        }

        for ($i=0; $i < $nombre; $i++) { 

            $url = $this->urlAleatoire();

            if ( ! in_array($url, $this->urls) )
            {
                array_push($liste, $url);
            }
        }
        
        return $liste;
    }

    private function urlAleatoire()
    {
        $response = $this->client->request('GET', $this->urlAleatoire);
        $response->getContent();
        return $response->getInfo()['url'];
    }

    
}