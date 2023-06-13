<?php
declare(strict_types=1);


require_once '../vendor/autoload.php';

use Database\MyPdo;
use Html\WebPage;
use Entity\Actor;
use Entity\Exception\EntityNotFoundException;



MyPDO::setConfiguration('mysql:host=mysql;dbname=souk0003_movie;charset=utf8', 'souk0003', 'Ouinouin2023');

$webPage = new WebPage();
$actor = new Actor($_GET["name"],$_GET["birthplace"],$_GET["birthdate"],$_GET["biography"],$_GET["deathDay"]);

#Titre de la page
$webPage -> setTitle($actor->getName());

#Ajout fichier CSS
$webPage->appendCssUrl("/css/style_actor.css");

#Header
$webPage->appendContent("<h1>{$actor->getName()} </h1>");

#content
$vignette=" "; #à completer
$webPage->appendContent("<div>");
$webPage->appendContent("<img src='/poster.php?posterId={$vignette}'>");
$webPage->appendContent("<p>{$actor->getName()} </p>");
$webPage->appendContent("<p>{$actor->getBirthPlace()} </p>");
$webPage->appendContent("<p>{$actor->getBirthdate()} - {$actor->getDeathDay()}</p>");
$webPage->appendContent("<p>{$actor->getBiography()} </p>");
$webPage->appendContent("<\div>");


# à completer, implementer la variable dans le where
$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT title, role, releaseDate, posterid
    FROM movie m, cast c
    WHERE peopleID = [#insert actor id]
    ORDER BY orderIndex
SQL
);

$stmt->execute();

while (($ligne = $stmt->fetch()) !== false) {
    $poster = ""; #Code à compléter
    $webPage->appendContent("<div>");
    $webPage->appendContent("<img src='/poster.php?posterId={$poster}'>");
    $webPage->appendContent("<p>{$ligne['title']}</p>\n");
    $webPage->appendContent("<p>{$ligne['role']}</p>\n");
    $webPage->appendContent("<p>{$ligne['releaseDate']}</p>\n");
    $webPage->appendContent("</div>");
}

#Footer
$webPage->appendContent("<p>{$webPage->getLastModification()}</p>");

echo $webPage->toHTML();
