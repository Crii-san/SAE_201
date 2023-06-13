<?php
declare(strict_types=1);

require_once '../vendor/autoload.php';

use Database\MyPdo;
use Html\WebPage;
use Entity\Movie;
use Entity\Exception\EntityNotFoundException;

MyPDO::setConfiguration('mysql:host=mysql;dbname=souk0003_movie;charset=utf8', 'souk0003', 'Ouinouin2023');

$movieId = intval($_GET['movieId']);

$webPage = new WebPage();
$movie = Movie::findById($movieId);

#Titre de la page
$webPage -> setTitle($movie->getTitle());

#Ajout fichier CSS
$webPage->appendCssUrl("/css/style.css");

#Header
$webPage->appendContent("<h1 class='header'>Films - {$movie->getTitle()} </h1>");

#content

# Film
$poster = $movie->getPosterId();
$webPage->appendContent("<div>");
$webPage->appendContent("<img src='/poster.php?posterId={$poster}' alt='Affiche du film'>");
$webPage->appendContent("<p>Titre : {$movie->getTitle()} </p>");
$webPage->appendContent("<p>Date de sortie : {$movie->getReleaseDate()} </p>");
$webPage->appendContent("<p>Titre original : {$movie->getOriginalTitle()}</p>");
$webPage->appendContent("<p>Slogan :{$movie->getTagline()} </p>");
$webPage->appendContent("<p>Résumé : {$movie->getOverview()} </p>");
$webPage->appendContent("</div>");

# Acteurs

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

while (($ligne = $stmt->fetch()) !== false) {
    $vignette = $ligne['avatarId'];
    $actorId = $ligne['id'];

    #lien vers l'acteur
    $webPage->appendContent("<a href='/actor.php?actorId={$actorId}'>");

    $webPage->appendContent("<img src='/poster.php?posterId={$vignette}' alt='Photo de l'acteur>");
    $webPage->appendContent("<p>Rôle : {$ligne['role']}</p>\n");
    $webPage->appendContent("<p>Acteur : {$ligne['name']}</p>\n");

    $webPage->appendContent("</a>");
}


#Footer
$webPage->appendContent("<p class='footer'>Dernière mofication : {$webPage->getLastModification()}</p>");

echo $webPage->toHTML();
