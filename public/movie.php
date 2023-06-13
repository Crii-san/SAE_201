<?php
declare(strict_types=1);


require_once '../vendor/autoload.php';

use Database\MyPdo;
use Html\WebPage;
use Entity\Actor;
use Entity\Movie;
use Entity\Exception\EntityNotFoundException;

MyPDO::setConfiguration('mysql:host=mysql;dbname=souk0003_movie;charset=utf8', 'souk0003', 'Ouinouin2023');

$movieId = intval($_GET['movieId']);

$webPage = new WebPage();
$movie = Movie::findById($movieId);

#Titre de la page
$webPage -> setTitle($movie->getTitle());

#Ajout fichier CSS
$webPage->appendCssUrl("/css/style_movie.css");

#Header
$webPage->appendContent("<h1>Films - {$movie->getTitle()} </h1>");

#content
$poster = $movie->getPosterId();
$webPage->appendContent("<div>");
$webPage->appendContent("<img src='/poster.php?posterId={$poster}'>");
$webPage->appendContent("<p>{$movie->getTitle()} </p>");
$webPage->appendContent("<p>{$movie->getReleaseDate()} </p>");
$webPage->appendContent("<p>{$movie->getOriginalTitle()}</p>");
$webPage->appendContent("<p>{$movie->getTagline()} </p>");
$webPage->appendContent("<p>{$movie->getOverview()} </p>");
$webPage->appendContent("<\div>");


# à completer, implementer la variable dans le where
/*
$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT role, name,birthday,deathDay,biography,placeOfBirth
    FROM people p, cast c, movie m
    WHERE p.peopleId = c.peopleId
    AND c.movieId = m.movieId
    ORDER BY orderIndex
SQL
);

$stmt->execute();

while (($ligne = $stmt->fetch()) !== false) {
    $vignette = ""; #Code à compléter
    $webPage->appendContent("<a href='actor.php?name={$ligne['name']}&?birthplace={$ligne['placeOfBirth']}&?birthdate={$ligne['birthday']}&?biography={$ligne['biography']}&?deathDay={$ligne['deathDay']}'><div>");
    $webPage->appendContent("<img src='/poster.php?posterId={$poster}'>");
    $webPage->appendContent("<p>{$ligne['role']}</p>\n");
    $webPage->appendContent("<p>{$ligne['name']}</p>\n");
    $webPage->appendContent("</div></a>");
}
*/
#Footer
/*
$webPage->appendContent("<p>{$webPage->getLastModification()}</p>");
*/
echo $webPage->toHTML();
