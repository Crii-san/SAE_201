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

# Vignette par défaut en cas de nullabilité de l'identifiant
/*
$src = "http://cutrona/but/s2/sae2-01/ressources/public/img/actor.png";*/

if (Poster::findById((int)$_GET['posterId'])) {
    $src = Poster::findById((int)$_GET['posterId']);
} elseif (Poster::findById((int)$_GET['posterId']) ==null) {
    $src = "http://cutrona/but/s2/sae2-01/ressources/public/img/actor.png";
}
header("Content-type: image/jpeg");
echo $src->getJpeg();
/*
catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}*/
