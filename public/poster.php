<?php
declare(strict_types=1);

require_once '../vendor/autoload.php';
use Database\MyPdo;
use Entity\Poster;
use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;

MyPDO::setConfiguration('mysql:host=mysql;dbname=souk0003_movie;charset=utf8', 'souk0003', 'Ouinouin2023');

try {
    if (!isset($_GET['posterId']) || !ctype_digit($_GET['posterId'])) {
        throw new ParameterException("Erreur");
    }
    $cover = Poster::findById((int)$_GET['posterId']);
    header("Content-type: image/jpeg");
    echo $cover->getJpeg();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}