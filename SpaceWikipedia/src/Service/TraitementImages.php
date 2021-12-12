<?php
namespace App\Service;

class TraitementImages
{
    public function telechargeImage(string $titre, string $url)
    {
        $donneeImage = file_get_contents($url);
        $path = "..\images\\" . $titre;
        file_put_contents($path,$donneeImage);
    }
}