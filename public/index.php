<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Database\MyPdo;
use Entity\Poster;
use Html\WebPage;

MyPDO::setConfiguration('mysql:host=mysql;dbname=souk0003_movie;charset=utf8', 'souk0003', 'Ouinouin2023');

$webPage = new WebPage();

#Titre de la page
$webPage -> setTitle("Liste des films");

#Ajout fichier CSS
$webPage->appendCssUrl("/css/style.css");

#Header
$webPage->appendContent("<h1>Films</h1>");

#Content

$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
        SELECT *
        FROM movie
        SQL
);
$stmt->execute();

while (($ligne = $stmt->fetch()) !== false) {
    $poster = $ligne['posterId'];
    $webPage->appendContent("<a href='/movie.php?movieId={$ligne['id']}'>");
    $webPage->appendContent("<img src='/poster.php?posterId={$poster}' alt='Poster du film'>");
    $webPage->appendContent("<p>{$ligne['title']}</p>\n");
    $webPage->appendContent("</a><br>");
}

#Footer
$webPage->appendContent("<p>{$webPage->getLastModification()}</p>");

echo $webPage->toHTML();
