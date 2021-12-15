<?php
namespace App\Service;

use App\Entity\Article;
use \Wa72\HtmlPageDom\HtmlPageCrawler;
use Doctrine\Persistence\ManagerRegistry;

class TraitementLiens
{

    private $doctrine;



    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function remplacementLiens(Article $article)
    {
        set_time_limit(180);

        $crawler = new HtmlPageCrawler($article->getHtml());
        $crawler->filter('a')->each(
            function (HtmlPageCrawler $node, $i)
            {
                $node->replaceWith($node->html());
                
            }
        );

        $html = $crawler->saveHTML();
        $article->setHtml($html);

        $manager = $this->doctrine->getManager();
        $manager->persist($article);
        $manager->flush();

        return $article;
    }
}