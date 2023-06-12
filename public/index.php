<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Database\MyPdo;
use Html\WebPage;

MyPDO::setConfiguration('mysql:host=mysql;dbname=souk0003_movie;charset=utf8', 'souk0003', 'Ouinouin2023');

$webpage = new WebPage();

#Titre de la page
$webpage -> setTitle("Liste des films");

#Header
$webpage->appendContent("<h1>Films</h1>");

#Content
$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT id, title
    FROM movie
SQL
);

$stmt->execute();

while (($ligne = $stmt->fetch()) !== false) {
    $webpage->appendContent("<p>{$ligne['title']}</p>\n");
}

#Footer
$webpage->appendContent("<p>{$webpage->getLastModification()}</p>");


echo $webpage->toHTML();
