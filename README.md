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