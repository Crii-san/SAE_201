<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Database\MyPdo;
use Html\WebPage;

# Connection à la base de donnée
MyPDO::setConfiguration('mysql:host=mysql;dbname=souk0003_movie;charset=utf8', 'souk0003', 'Ouinouin2023');

# Création de la page web
$webPage = new WebPage();

# Initialisation du titre de la page
$webPage -> setTitle("Liste des films");

# Liaison du fichier CSS
$webPage->appendCssUrl("/css/style.css");

# Header
$webPage->appendContent("<div class='header'>");
$webPage->appendContent("<h1 >Films</h1>");
$webPage->appendContent("</div>");

# Content
$webPage->appendContent("<div class='content'>");

# Requête qui liste tous les films de la base de données
$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
        SELECT *
        FROM movie
        ORDER BY title
        SQL
);
$stmt->execute();

# Ajout de la liste des films de l'acteur
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

# Footer
$webPage->appendContent("<div class='footer'>");
$webPage->appendContent("<p>Dernière modification : {$webPage->getLastModification()}</p>");
$webPage->appendContent("</div>");

# Affichage de la page
echo $webPage->toHTML();
