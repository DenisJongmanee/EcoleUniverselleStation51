<?php
namespace App\Service;

class ScrapperWikipedia
{

    private $htmlManager;
    private $imageManager;
    private $lienManager;

    public function __construct(GetHTML $htmlManager, TraitementImages $imageManager, TraitementLiens $lienManager)
    {
        $this->htmlManager = $htmlManager;
        $this->imageManager = $imageManager;
        $this->lienManager = $lienManager;
    }

    public function scrapListe(array $listeUrl)
    {
        set_time_limit(1800);

        foreach ($listeUrl as $url)
        {
            $html = $this->htmlManager->getBody($url);
            $article = $this->htmlManager->enregistrerArticle($html);
            $article = $this->imageManager->remplacementImagesArticle($article);
            $article = $this->lienManager->remplacementLiens($article);
        }
    }
}