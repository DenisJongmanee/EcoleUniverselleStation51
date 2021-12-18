<?php
namespace App\Service;

use Doctrine\Persistence\ManagerRegistry;

class ScrapperWikipedia
{

    private $htmlManager;
    private $imageManager;
    private $lienManager;
    private $cleanManager;
    private $doctrine;

    public function __construct(GetHTML $htmlManager, TraitementImages $imageManager, TraitementLiens $lienManager, CleanArticle $cleanManager, ManagerRegistry $doctrine)
    {
        $this->htmlManager = $htmlManager;
        $this->imageManager = $imageManager;
        $this->lienManager = $lienManager;
        $this->cleanManager = $cleanManager;
        $this->doctrine = $doctrine;
    }

    public function scrapListe(array $listeUrl)
    {
        set_time_limit(1800);

        $colecteur_erreur = [];
        $manager = $this->doctrine->getManager();

        foreach ($listeUrl as $url)
        {
            #Ces try catch sont uniquement des bandages pour rendre le code demain soir.
            #Si ce code est réutilisé, il est nécessaire d'écrire une véritable gestion des erreurs
            #colecteur_erreur est la pour du debug si une exception vraiment critique est lancée.
            try {
                $donneeArticle = $this->htmlManager->getBody($url);
                $article = $this->htmlManager->enregistrerArticle($donneeArticle['html'],$donneeArticle['titre']);
            } catch (\Throwable $th) {
                array_push($colecteur_erreur,$th);
                continue;
                #throw $th; si bug incompris.
            }
            

            try {
                $article = $this->imageManager->remplacementImagesArticle($article);
                
                $article = $this->lienManager->remplacementLiens($article);
                
                $categorieManager = new GetCategorie($this->doctrine, $article);
                $categorieManager->ajoutCategories();

                $this->cleanManager->cleanText($article);
                $this->cleanManager->addCss($article);

            } catch (\Throwable $th) {
                array_push($colecteur_erreur,$th);
                
                #nettoyeur de mémoire
                $pathDossier = "..\images\ArticleN" . strval($article->getId());
                foreach(glob($pathDossier . '/Image*') as $file) { 
                    unlink($file); 
                }
                rmdir($pathDossier);

                $manager->remove($article);
                $manager->flush();

                continue;
                #throw $th; si bug incompris.
            }
        }
        return $colecteur_erreur;
    }
}