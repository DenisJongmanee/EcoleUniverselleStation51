<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DomCrawler\Crawler;
use \Wa72\HtmlPageDom\HtmlPageCrawler;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Article;

class CleanArticle
{
    private $doctrine;
    private const BLOCKSTOBEREMOVED = [
        ".bandeau-container",
        ".autres-projets",
        ".mw-editsection",
        ".reference",
        "#Notes_et_références",
        ".references-small",
        ".boite-grise",
        ".navbox-container",
        ".navbox ",
        ".noprint",
        "#bandeau-portail",
        "#mw-hidden-catlinks",
        "#Exemple",
        ".need_ref_tag"
    ];
    
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine=$doctrine;
    }

    public function cleanText(Article $article)
    {

        $crawler = new HtmlPageCrawler($article->getHtml());
        
        foreach(self::BLOCKSTOBEREMOVED as $block)
        {
            $crawler->filter($block)->each(
                function ($subcrawler, $i) {
                    $subcrawler->remove();
                }
            );
        }
        $html = $crawler->saveHTML();
        dump($html);
        $article->setHtml($html);

        $manager = $this->doctrine->getManager();
        $manager->persist($article);
        $manager->flush();
    }

    public function addCss(Article $article)
    {
        $crawler = new HtmlPageCrawler($article->getHtml());
        
        $crawler->filter("ul")->addClass("list-group");

        $crawler->filter(".toclevel-1")->addClass("list-group-item");
        $crawler->filter(".toclevel-2")->addClass("nopuce");
        $crawler->filter(".toclevel-3")->addClass("nopuce");
        
        $crawler->filter(".catlinks li")->addClass("list-group-item");
        
        $crawler->filter("table")->addClass("table");
        

        $html = $crawler->saveHTML();
        $article->setHtml($html);
        $manager = $this->doctrine->getManager();
        $manager->persist($article);
        $manager->flush();
        
    }
}
