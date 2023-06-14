<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';
use Database\MyPdo;
use Entity\Poster;

# Connection à la base de données
MyPDO::setConfiguration('mysql:host=mysql;dbname=souk0003_movie;charset=utf8', 'souk0003', 'Ouinouin2023');

# Vérification de l'existence d'un poster pour l'id fourni

# Test de la validité de identifiant
if (!isset($_GET['posterId']) || !ctype_digit($_GET['posterId'])) {
    throw new Exception("L'identifiant donné n'est pas valide.");
}

if (Poster::findById((int)$_GET['posterId'])) {
    $src = Poster::findById((int)$_GET['posterId']);
    header("Content-type: image/jpeg");
    echo $src->getJpeg();
}
