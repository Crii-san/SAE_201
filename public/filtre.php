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
$webPage -> setTitle("Formulaire de trie des films");

# requetes de la liste des genres
$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
        SELECT name, id
        FROM genre
        SQL
);
$stmt->execute();

#création du formulaire
$webPage->appendContent("<form action='/index.php' method='get'> <p>What gender do you want to search</p>");

# liste des genres
while (($ligne = $stmt->fetch()) !== false) {
    $webPage->appendContent("<input type='radio' id={$ligne['name']} name='filtre' value={$ligne['id']}>");
    $webPage->appendContent("<label for='html'>{$ligne['name']}</label><br>");
}
# bouton d'envois du formulaire
$webPage->appendContent("<input type='submit' value='Submit'>");
