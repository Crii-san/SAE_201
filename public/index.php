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

#requete liste des films présent dans la table
if (!isset($_GET['filtre'])){
    $stmt = MyPDO::getInstance()->prepare(
        <<<'SQL'
        SELECT *
        FROM movie m,movie_genre mg
        WHERE mg.movieId = m.id
        AND mg.genreId IN :filtre
        SQL
    );
    $stmt->bindValue(':filtre', $_GET['filtre'], PDO::PARAM_INT);
    $stmt->execute();
}
else{
$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
        SELECT *
        FROM movie
        ORDER BY title
        SQL
);
    $stmt->execute();
}

# Ajout de la liste des films de l'acteur
while (($element = $stmt->fetch()) !== false) {
    $webPage->appendContent("<a href='/movie.php?movieId={$element['id']}'>");
    $webPage->appendContent("<div class='film'>");
    $poster = $element['posterId'];
    $webPage->appendContent("<img src='/poster.php?posterId={$poster}' alt='Poster du film'>");
    $webPage->appendContent("<p>{$element['title']}</p>\n");
    $webPage->appendContent("</div>");
    $webPage->appendContent("</a><br>");
}
$webPage->appendContent("</div>");

#accéder à la page de trie
$webPage->appendContent("<a href='/filtre.php'>Trier les films par genre?</a>");


#Footer
$webPage->appendContent("<div class='footer'>");
$webPage->appendContent("<p>Dernière modification : {$webPage->getLastModification()}</p>");
$webPage->appendContent("</div>");

# Affichage de la page
echo $webPage->toHTML();
