<?php
namespace App\Service;

use App\Entity\Article;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Crap4j;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use \Wa72\HtmlPageDom\HtmlPageCrawler;

class TraitementImages
{
    private $fileManager;


    public function __construct(Filesystem $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function telechargeImage(int $articleId, string $titre, string $url)
    {
        $pathDossier = "..\images\Article N°" . strval($articleId);
        if (! $this->fileManager->exists($pathDossier))
        {
            $this->fileManager->mkdir($pathDossier);
        }
        $donneeImage = file_get_contents($url);
        $pathImage = $pathDossier . "\\" . $titre;
        file_put_contents($pathImage,$donneeImage);
    }

    public function trouveImages(Article $article)
    {
        $crawler = new HtmlPageCrawler($article->getHtml());
        $crawler->filter('img')->addClass("ImagesTrouvees");
        $html = $crawler->saveHTML();

        $article->setHtml($html);

        $this->index = 1;
        $this->id = $article->getId();

        $crawler->each(
            function (Crawler $node, $i)
            {
                $url = $node->attr('src');
                $titre = "Image" . strval($this->index);
                $this->telechargeImage($this->id, $titre, $url);

                $this->index += 1;
            }
        );

        $this->index->unset();
        $this->id->unset();
    }


}