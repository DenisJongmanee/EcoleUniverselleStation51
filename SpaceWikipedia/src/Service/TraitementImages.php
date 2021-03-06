<?php
namespace App\Service;

use App\Entity\Article;
use \Wa72\HtmlPageDom\HtmlPageCrawler;
use Symfony\Component\Filesystem\Path;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class TraitementImages
{
    private $fileManager;
    private $doctrine;
    private $client;


    public function __construct(HttpClientInterface $client, Filesystem $fileManager, ManagerRegistry $doctrine)
    {
        $this->client = $client;
        $this->fileManager = $fileManager;
        $this->doctrine = $doctrine;
    }

    private function telechargeImage(int $articleId, string $titre, string $url)
    {
        $pathDossier = "..\images\ArticleN" . strval($articleId);
        if (! $this->fileManager->exists($pathDossier))
        {
            $this->fileManager->mkdir($pathDossier);
        }
        $reponse = $this->client->request('GET', $url);

        #$donneeImage = file_get_contents($url);

        $donneeImage = $reponse->getContent();

        $pathImage = $pathDossier . "\\" . $titre;
        file_put_contents($pathImage,$donneeImage);
    }

    private function trouveImages(Article $article)
    {
        $crawler = new HtmlPageCrawler($article->getHtml());
        $crawler->filter('img')->addClass("ImagesTrouvees");
        $html = $crawler->saveHTML();

        $article->setHtml($html);

        $manager = $this->doctrine->getManager();
        $manager->persist($article);
        $manager->flush();

    }

    private function telechargeImagesArticle(Article $article)
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
                    
                    if ( str_starts_with($url, 'https://'))
                    {
                        throw new ImageException("L'article contient des images non g??r??es");
                    }

                    $url = 'https:' . $url;

                    # Mettre une s??curit?? pour mettre l'extension de l'image au lieu de jpg par d??fault
                    $titre = "Image" . strval($this->index) . '.jpg';

                    $this->telechargeImage($this->id, $titre, $url);

                    $this->index += 1;
                }
            }
        );
    }

    private function ajoutCheminImagesLocale(Article $article)
    {
        $this->index = 1;
        $this->articleId = $article->getId();

        $crawler = new HtmlPageCrawler($article->getHtml());

        $crawler->filter('.ImagesTrouvees')->each(
            function (HtmlPageCrawler $subCrawler, $i)
            {
                $path = "/article" . strval($this->articleId) . "/image" . strval($this->index);
                
                $subCrawler->setAttribute('src',$path);

                $this->index += 1;
            }
        );
        #potentielle fonction (utilis??e 2 fois)
        $html = $crawler->saveHTML();

        #dump($html);

        $article->setHtml($html);

        $manager = $this->doctrine->getManager();
        $manager->persist($article);
        $manager->flush();
    }


    public function remplacementImagesArticle(Article $article)
    {
        set_time_limit(300);

        $this->trouveImages($article);
        $this->telechargeImagesArticle($article);
        $this->ajoutCheminImagesLocale($article);
        return $article;
    }
}