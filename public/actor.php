<?php
declare(strict_types=1);

require_once '../vendor/autoload.php';

use Database\MyPdo;
use Html\WebPage;
use Entity\Actor;
use Entity\Exception\EntityNotFoundException;

MyPDO::setConfiguration('mysql:host=mysql;dbname=souk0003_movie;charset=utf8', 'souk0003', 'Ouinouin2023');

$actorId = $_GET['actorId'];

$webPage = new WebPage();

# Acteur concerné par la fiche
$actor = Actor::findById($actorId);

#Titre de la page
$webPage -> setTitle($actor->getName());

#Ajout fichier CSS
$webPage->appendCssUrl("/css/style_actor.css");

#Header
$webPage->appendContent("<h1>Films - {$actor->getName()}</h1>");

#content

# Informations sur l'acteur
if ($actor->getDeathDay() == null) {
    $res = "";
} else {
    $res = "- Mort le : ".$actor->getDeathDay();
}
$vignette = $actor->getAvatarId();
$webPage->appendContent("<div>");
$webPage->appendContent("<img src='/poster.php?posterId={$vignette}'>");
$webPage->appendContent("<p>Nom : {$actor->getName()} </p>");
$webPage->appendContent("<p>Lieu de naissance : {$actor->getBirthPlace()} </p>");
$webPage->appendContent("<p>Né le : {$actor->getBirthday()} {$res}</p>");
$webPage->appendContent("<p>Biographie : {$actor->getBiography()} </p>");
$webPage->appendContent("</div>");

#Informantions sur les films de l'acteur
# à completer, implementer la variable dans le where
/*
$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT title, role, releaseDate, posterid,originalLanguage,originalTitle,overview,runtime,tagline
    FROM movie m, cast c
    WHERE peopleID = [#insert actor id]
    ORDER BY orderIndex
SQL
);

$stmt->execute();

while (($ligne = $stmt->fetch()) !== false) {
    $poster = ""; #Code à compléter
    $webPage->appendContent("<a href='movie.php?title={$ligne['title']}&?releaseDate={$ligne['releaseDate']}&?originalLanguage={$ligne['originalLanguage']}&?originalTitle={$ligne['originalTitle']}&?overview={$ligne['overview']}&?runtime={$ligne['runtime']}?tagline={$ligne['tagline']}&'><div>");
    $webPage->appendContent("<img src='/poster.php?posterId={$poster}'>");
    $webPage->appendContent("<p>{$ligne['title']}</p>\n");
    $webPage->appendContent("<p>{$ligne['role']}</p>\n");
    $webPage->appendContent("<p>{$ligne['releaseDate']}</p>\n");
    $webPage->appendContent("</div></a>");
}
*/

#Footer
$webPage->appendContent("<p>{$webPage->getLastModification()}</p>");

echo $webPage->toHTML();
