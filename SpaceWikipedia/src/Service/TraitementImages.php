<?php
namespace App\Service;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

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
}