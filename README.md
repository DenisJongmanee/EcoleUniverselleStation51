# EcoleUniverselleStation51

## feature : getHTML
    Le but de getHTML est de reccuper le corps HTML d'un page depuis un url et les composants symfony.
### getBody($url)
    Cette fonction demande un string contenant un url d'un article wikipedia.
    Elle retourne un string format html contenant la div décrivant le contenu de l'article.
    Ce retour est raw, sans css et avec des liens morts.
### enregistrerArticle($html, $titre = "")
    Cette fonction demande un string format html contenant la div décrivant le contenu d'un article.
    Elle enregistre l'article dans la base de donnée.
    Elle dump les erreurs sur l'enregistrements.
    Elle ne retourne rien.

## feature : remplacementImage
    Le but de remplacementImage est de télécharger en local les images d'un article puis de pointer les balises images de l'article vers la version locale.
### trouveImages(Article $article)
    Cette fonction demande un article.
    Elle va ajouter la classe css 'ImagesTrouvees' dans toute les balises img de l'html de l'article.
### telechargeImagesArticle(Article $article)
    Cette fonction demande un article.
    Elle va chercher les images dans l'html de l'article et les téléchargés avec la fonction telechargeImage() et un titre composé de 'Image' et d'un entier.
    Cette entier est l'ordre d'apparition de l'image dans l'article de haut en bas.
### telechargeImage(int $articleId, string $titre, string $url)
    Cette fonction demande un int identifiant un article, un string tritre de l'image et un string url où ce trouve l'image en ligne.
    Elle télécharge l'image dans le dossier 'ArticleN'articleId sous le nom de titre.
### ajoutCheminImagesLocale(Article $article)
    Cette fonction demande un article.
    Elle va ajouter le chemin des images de l'article vers le controller ImageController
### ImageController
    Ce controller utilise la route '/article{articleId}/image{imageId}'.
    Il met a disposition des requêttes GET l'image imageId de l'article N° articleId.