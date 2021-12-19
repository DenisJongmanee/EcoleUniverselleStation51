<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DomCrawler\Crawler;
use \Wa72\HtmlPageDom\HtmlPageCrawler;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Article;
use App\Entity\Categorie;

class GetCategorie
{
    private $doctrine;
    private $article;
    
    public function __construct(ManagerRegistry $doctrine, Article $article)
    {
        $this->doctrine=$doctrine;
        $this->article=$article;
    }


    public function ajoutCategories()
    {
        $crawler = new Crawler($this->article->getHtml());
        
        $crawler->filter("#mw-normal-catlinks ul li")->each(
            function(Crawler $subCrawler, $index) {
                $libelleCategorie = $subCrawler->text();
                $this->createCategorie($libelleCategorie, $this->article);
            }
        );
    }

    private function createCategorie(string $libelle)
    {
        //savoir si la catégorie existe déjà
        $categorie = $this->doctrine->getRepository(Categorie::class)->findOneBy(['libelle'=>$libelle]);
        
        if (!$categorie) {
            $categorie = new Categorie();
            $categorie->setLibelle($libelle);
        }

        $categorie->addArticle($this->article);

        $manager = $this->doctrine->getManager();
        $manager->persist($categorie);
        $manager->flush();

    }
}
