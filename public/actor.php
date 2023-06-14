<?php
declare(strict_types=1);

require_once '../vendor/autoload.php';

use Database\MyPdo;
use Html\WebPage;
use Entity\Actor;
use Entity\Exception\EntityNotFoundException;

# Connection à la base de donnée
MyPDO::setConfiguration('mysql:host=mysql;dbname=souk0003_movie;charset=utf8', 'souk0003', 'Ouinouin2023');

# Récupération de l'id de l'acteur
$actorId = $_GET['actorId'];

# Création de la page web
$webPage = new WebPage();

# Création de l'acteur concerné par la fiche
$actor = Actor::findById($actorId);

# Initialisation du titre de la page
$webPage -> setTitle($actor->getName());

# Liaison du fichier CSS
$webPage->appendCssUrl("/css/style.css");

# Initialisation de l'header de la page
$webPage->appendContent("<h1 class='header'>Films - {$actor->getName()}</h1>");


$webPage->appendContent("<div class='content'>");

# ajout des informations de l'acteur
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


# Requete des informations sur les films de l'acteur

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

#Renvois la liste des films de l'acteur
while (($ligne = $stmt->fetch()) !== false) {
    $idPoster = $ligne['posterId'];
    $webPage->appendContent("<a href='/movie.php?movieId={$ligne['movieId']}>");
    $webPage->appendContent("<img src='/poster.php?posterId={$idPoster}' alt='Affiche du film'>");
    $webPage->appendContent("<p>Film : {$ligne['title']}</p>\n");
    $webPage->appendContent("<p>Rôle : {$ligne['role']}</p>\n");
    $webPage->appendContent("<p>Date de sortie : {$ligne['releaseDate']}</p>\n");
    $webPage->appendContent("</a>");
}
$webPage->appendContent("<div>");

#Footer
$webPage->appendContent("<p class='footer'>Dernière modification {$webPage->getLastModification()}</p>");

# envois de la page html
echo $webPage->toHTML();
