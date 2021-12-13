<?php
namespace App\Service;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\DomCrawler\Crawler;
use \Wa72\HtmlPageDom\HtmlPageCrawler;


class TraitementImages
{
    private $fileManager;
    private $doctrine;


    public function __construct(Filesystem $fileManager, ManagerRegistry $doctrine)
    {
        $this->fileManager = $fileManager;
        $this->doctrine = $doctrine;
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

        $manager = $this->doctrine->getManager();
        $manager->persist($article);
        $manager->flush();

    }

    public function telechargeImagesArticle(Article $article)
    {
        $this->index = 1;
        $this->id = $article->getId();

        $crawler = new HtmlPageCrawler($article->getHtml());
        $crawler->filter('.ImagesTrouvees')->each(
            function (Crawler $node, $i)
            {
                $element = $node->getNode(0);
                if ($element instanceof \DOMElement) {
                    /** @var \DOMElement $node */
                    $url =$node->getAttribute('src');
                    $url = 'https:' . $url;
                    
                    # Mettre une sécurité pour mettre l'extension de l'image au lieu de jpg par défault
                    $titre = "Image" . strval($this->index) . '.jpg';

                    $this->telechargeImage($this->id, $titre, $url);

                    $this->index += 1;
                }
            }
        );
    }

    public function ajoutCheminImagesLocale(Article $article)
    {
        $this->index = 1;
        $this->articleId = $article->getId();

        $crawler = new HtmlPageCrawler($article->getHtml());

        $crawler->filter('.ImagesTrouvees')->each(
            function (HtmlPageCrawler $subCrawler, $i)
            {
                $path = "..\images\Article N°" . strval($this->articleId) . "\Image" . strval($this->index) . '.jpg';
                $subCrawler->setAttribute('src',$path);

                $this->index += 1;
            }
        );
        #potentielle fonction (utilisée 2 fois)
        $html = $crawler->saveHTML();

        $article->setHtml($html);

        $manager = $this->doctrine->getManager();
        $manager->persist($article);
        $manager->flush();
    }
}