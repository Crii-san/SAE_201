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
$webPage->appendCssUrl("/css/style.css");

#Header
$webPage->appendContent("<h1 class='header'>Films - {$actor->getName()}</h1>");

#content

# Informations sur l'acteur
if ($actor->getDeathDay() == null) {
    $res = "";
} else {
    $res = "- Mort le : ".$actor->getDeathDay();
}
$vignette = $actor->getAvatarId();
$webPage->appendContent("<div>");
$webPage->appendContent("<img src='/poster.php?posterId={$vignette}' alt='Photo acteur>");
$webPage->appendContent("<p>Nom : {$actor->getName()} </p>");
$webPage->appendContent("<p>Lieu de naissance : {$actor->getBirthPlace()} </p>");
$webPage->appendContent("<p>Né le : {$actor->getBirthday()} {$res}</p>");
$webPage->appendContent("<p>Biographie : {$actor->getBiography()} </p>");
$webPage->appendContent("</div>");

#Informations sur les films de l'acteur
# à completer, implementer la variable dans le where

$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT *
    FROM movie m, cast c
    WHERE c.movieId = m.id
    AND peopleID = :actorId
    ORDER BY orderIndex
SQL
);

$stmt->bindValue(':actorId', $actorId, PDO::PARAM_INT);
$stmt->execute();

while (($ligne = $stmt->fetch()) !== false) {
    $idPoster = $ligne['posterId'];
    $webPage->appendContent("<a href='/movie.php?movieId={$ligne['movieId']}>");
    $webPage->appendContent("<img src='/poster.php?posterId={$idPoster}' alt='Affiche du film'>");
    $webPage->appendContent("<p>Film : {$ligne['title']}</p>\n");
    $webPage->appendContent("<p>Rôle : {$ligne['role']}</p>\n");
    $webPage->appendContent("<p>Date de sortie : {$ligne['releaseDate']}</p>\n");
    $webPage->appendContent("</a>");
}

#Footer
$webPage->appendContent("<p class='footer'>{$webPage->getLastModification()}</p>");

echo $webPage->toHTML();
