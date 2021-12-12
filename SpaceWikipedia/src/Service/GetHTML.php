<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DomCrawler\Crawler;


class GetHTML
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getBody($url)
    {
        $reponse = $this->client->request('GET', $url);
        $html = $reponse->getContent();
        $crawler = new Crawler($html);
        $contenu = $crawler->filter('#bodyContent')->html();

        return $contenu;
    }
}