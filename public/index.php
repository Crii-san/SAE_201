<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Database\MyPdo;
use Entity\Poster;
use Html\WebPage;

# Connection à la base de donnée
MyPDO::setConfiguration('mysql:host=mysql;dbname=souk0003_movie;charset=utf8', 'souk0003', 'Ouinouin2023');

# Création de la page web
$webPage = new WebPage();

# Initialisation du titre de la page
$webPage -> setTitle("Liste des films");

# Liaison du fichier CSS
$webPage->appendCssUrl("/css/style.css");

# Initialisation de l'header de la page
$webPage->appendContent("<h1 class='header'>Films</h1>");

#

$webPage->appendContent("<div class='content'>");

#requete liste des films présent dans la table
$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
        SELECT *
        FROM movie
        SQL
);
$stmt->execute();

#ajout de la liste des films de l'acteur
while (($ligne = $stmt->fetch()) !== false) {
    $webPage->appendContent("<a href='/movie.php?movieId={$ligne['id']}'>");
    $webPage->appendContent("<div class='film'>");
    $poster = $ligne['posterId'];
    $webPage->appendContent("<img src='/poster.php?posterId={$poster}' alt='Poster du film'>");
    $webPage->appendContent("<p>{$ligne['title']}</p>\n");
    $webPage->appendContent("</div>");
    $webPage->appendContent("</a><br>");


}

$webPage->appendContent("</div>");

#Footer
$webPage->appendContent("<p class='footer'>Dernière modification {$webPage->getLastModification()}</p>");

# envois de la page html
echo $webPage->toHTML();
