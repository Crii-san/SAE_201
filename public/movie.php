<?php
declare(strict_types=1);


require_once '../vendor/autoload.php';

use Database\MyPdo;
use Html\WebPage;
use Entity\Actor;
use Entity\Movie;
use Entity\Exception\EntityNotFoundException;



MyPDO::setConfiguration('mysql:host=mysql;dbname=souk0003_movie;charset=utf8', 'souk0003', 'Ouinouin2023');

$webPage = new WebPage();
$movie = new Movie($_GET["originalLangue"],$_GET["originalTitle"],$_GET["overview"],$_GET["releaseDate"],$_GET["runtime"],$_GET["tagline"],$_GET["title"]);

#Titre de la page
$webPage -> setTitle($movie->getTitle());

#Ajout fichier CSS
$webPage->appendCssUrl("/css/style_movie.css");

#Header
$webPage->appendContent("<h1>{$movie->getTitle()} </h1>");

#content
$poster=" "; #à completer
$webPage->appendContent("<div>");
$webPage->appendContent("<img src='/poster.php?posterId={$poster}'>");
$webPage->appendContent("<p>{$movie->getTitle()} </p>");
$webPage->appendContent("<p>{$movie->getReleaseDate()} </p>");
$webPage->appendContent("<p>{$movie->getOriginalTitle()}</p>");
$webPage->appendContent("<p>{$movie->getTagline()} </p>");
$webPage->appendContent("<p>{$movie->getOverview()} </p>");
$webPage->appendContent("<\div>");


# à completer, implementer la variable dans le where
$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT role, name,birthday,deathDay,biography,placeOfBirth
    FROM people, cast 
    WHERE movieID = [#insert actor id]
    ORDER BY orderIndex
SQL
);


$stmt->execute();

while (($ligne = $stmt->fetch()) !== false) {
    $poster = ""; #Code à compléter
    $webPage->appendContent("<a href='actor.php?name={$ligne['name']}&?birthplace={$ligne['placeOfBirth']}&?birthdate={$ligne['birthday']}&?biography={$ligne['biography']}&?deathDay={$ligne['deathDay']}'><div>");
    $webPage->appendContent("<img src='/poster.php?posterId={$poster}'>");
    $webPage->appendContent("<p>{$ligne['role']}</p>\n");
    $webPage->appendContent("<p>{$ligne['name']}</p>\n");
    $webPage->appendContent("</div></a>");
}

#Footer
$webPage->appendContent("<p>{$webPage->getLastModification()}</p>");

echo $webPage->toHTML();
