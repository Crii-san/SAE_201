<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Database\MyPdo;
use Html\WebPage;
use Entity\Movie;


# Connection à la base de donnée
MyPDO::setConfiguration('mysql:host=mysql;dbname=souk0003_movie;charset=utf8', 'souk0003', 'Ouinouin2023');

# Récupération de l'id du film
$movieId = intval($_GET['movieId']);

# Création de la page web
$webPage = new WebPage();

# Création du film concerné par la fiche
$movie = Movie::findById($movieId);

# Initialisation du titre de la page
$webPage -> setTitle($movie->getTitle());

# Liaison du fichier CSS
$webPage->appendCssUrl("/css/style.css");

# Header
$webPage->appendContent("<div class='header'>");
$webPage->appendContent("<h1 >Films - {$movie->getTitle()} </h1>");
$webPage->appendContent("</div>");

# Content

$webPage->appendContent("<div class='content'>");

$webPage->appendContent("<div class='détailsFilm'>");

# intégration de l'affiche du film
$poster = $movie->getPosterId();
$webPage->appendContent("<img class='affiche' src='/poster.php?posterId={$poster}' alt='Affiche du film'>");
# ajout des informations du film
$webPage->appendContent("<div class='infosFilm'>");
$webPage->appendContent("<div class='x'>");
$webPage->appendContent("<p>Titre : {$movie->getTitle()} </p>");
$webPage->appendContent("<p>Date de sortie : {$movie->getReleaseDate()} </p>");
$webPage->appendContent("</div>");
$webPage->appendContent("<p class='titreOriginal'>Titre original : {$movie->getOriginalTitle()}</p>");
$webPage->appendContent("<p>Slogan : {$movie->getTagline()} </p>");
$webPage->appendContent("<p>Résumé : {$movie->getOverview()} </p>");

$webPage->appendContent("</div>");

$webPage->appendContent("</div>");

# Acteurs

$webPage->appendContent("<div class='actors'>");

# Requete des informations sur les acteurs du film

$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT p.id, role, name, birthday, deathDay, biography, placeOfBirth, avatarId
    FROM people p, cast c, movie m
    WHERE p.id = c.peopleId
    AND c.movieId = m.id
    AND m.id = :movieId
    ORDER BY orderIndex
SQL
);

$stmt->bindValue(':movieId', $movieId, PDO::PARAM_INT);
$stmt->execute();

#ajout de la liste des acteurs du film
while (($ligne = $stmt->fetch()) !== false) {

    $vignette = $ligne['avatarId'];
    $actorId = $ligne['id'];

    #lien vers l'acteur
    $webPage->appendContent("<a href='/actor.php?actorId={$actorId}'>");
    $webPage->appendContent("<div class='actor'>");
    #Poster
    if ($vignette == null) {
        $webPage->appendContent("<img src='http://cutrona/but/s2/sae2-01/ressources/public/img/actor.png' alt='Photo de l acteur'>");
    } else {
        $webPage->appendContent("<img src='/poster.php?posterId={$vignette}' alt='Photo de l acteur'>");
    }
    #Poster
    $webPage->appendContent("<div class='roleActor'>");
    $webPage->appendContent("<p>Rôle : {$ligne['role']}</p>\n");
    $webPage->appendContent("<p>Acteur : {$ligne['name']}</p>\n");
    $webPage->appendContent("</div>");
    $webPage->appendContent("</div>");
    $webPage->appendContent("</a>");
}

$webPage->appendContent("</div>");
$webPage->appendContent("</div>");

#Footer
$webPage->appendContent("<div class='footer'>");
$webPage->appendContent("<p>Dernière mofication : {$webPage->getLastModification()}</p>");
$webPage->appendContent("</div>");

# Affichage
echo $webPage->toHTML();
