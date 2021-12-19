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
### remplacementImagesArticle(Article $article)
    Cette fonction demande un article.
    Elle utilise trouveImages() puis telechargeImagesArticle() et ajoutCheminImagesLocale().
    Elle remplace toutes les images d'un article par une version locale.
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

## feature : remplacementLiensMorts
    Le but de remplacementLiensMorst est de retirer les liens morts d'un article
### remplacementLiens(Article $article)
    Cette fonction demande un article.
    Elle va retirer tout les liens du html de l'article sans supprimer l'html interne des anciennes balises <a>.

## feature : scrapper
    Le but de scrapper est de récuppéré des articles wikipedia et de les enregistrer en local sur le serveur.
### scrapListe(array $listeUrl)
    Cette fonction demande un array de string.
    Elle va scapper les articles wikipedia dont les urls sont présents dans la liste.
    Opérations de scrapping actuelles:
        -récupération du html et du titre
        -récupération des images en locales
        -suppression des liens morts
        -rangement dans un système de catégories
    Il y a une sécurité supprimant les articles soulevants des erreurs.

## feature : nouveauxArticles
    Le but de cette fonctionnalité est de générés des urls qui n'ont pas encore été scrappées.
### listeUrls(int $nombre)
    Cette fonction demande un int.
    Elle va retourner une liste de string url qui n'ont pas encore été scrappé par l'application.
### urlAleatoire()
    Cette fonction ne demande rien.
    Elle va retourner un string url aléatoire issus du site wikipedia.


## feature : getCategorie

### createCategorie(string $libelle)
    Créer la catégorie si elle n'existe pas et va faire le lien avec l'attribut article dans la base de données 
### ajoutCategories()
    Filtrer l'html de l'article pour récupérer ses catégories et faire appel à createCategorie() pour les insérer dans la base de donnéess

## feature : cleanArticle

### l'attribut BLOCKSTOBEREMOVED est une constante qui possède la liste des block à enlever

### cleanText(Article $article)
    Cette procédure va enlever tous les blocs listés dans la constante BLOCKSTOBEREMOVED
    Ces blocs sont considérés inutiles pour la ressource du projet
    Modification de l'article qui dans la base de données

### addCss(Article $article)
    Cette procédure va ajouter les classes CSS Bootstrap voulu pour la mise en forme de l'article
    Modification de l'article qui dans la base de données

### feature : findUrls

L'url https://fr.wikipedia.org/wiki/Sp%C3%A9cial:Page_au_hasard est utilisé pour récupérer un lieu au hasard
Il est utilisé pour scrapper un lien au hasard de wikipédia

## urlAleatoire()
    Cette fonction retourne un lien aléatoire de wikipédia

## listeUrls(int $nombre)
    Cette fonction retourne une liste de liens wikipédia générer par urlAleatoire()
    La taille de la liste dépend du paramètre $nombre
