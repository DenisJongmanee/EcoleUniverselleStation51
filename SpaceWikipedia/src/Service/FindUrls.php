<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class FindUrls
{
    private $urlAleatoire = 'https://fr.wikipedia.org/wiki/Sp%C3%A9cial:Page_au_hasard';

    private $client;


    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function listeUrls($nombre)
    {
        
    }

    public function urlAleatoire()
    {
        $response = $this->client->request('GET', $this->urlAleatoire);
        $response->getContent();
        return $response->getInfo()['url'];
    }
}