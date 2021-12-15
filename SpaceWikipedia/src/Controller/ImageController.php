<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImageController extends AbstractController
{
    #[Route('/article{articleId}/image{imageId}', name: 'image')]
    public function index(int $articleId, int $imageId): Response
    {
        dump("hello");
        $pathDossier = "..\images\ArticleN" . strval($articleId);

        $titre = "Image" . strval($imageId) . ".jpg";

        $pathImage = $pathDossier . "\\" . $titre ;

        #$filepath = $this->storage->resolveUri($pathImage);

        $response = new Response(file_get_contents($pathImage));

        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $titre);

        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'image/jpg');

        return $response;
    }
}
