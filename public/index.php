<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Database\MyPdo;

MyPDO::setConfiguration('mysql:host=mysql;dbname=souk0003_movie;charset=utf8', 'souk0003', 'Ouinouin2023');

$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
    SELECT id, title
    FROM movie
SQL
);

$stmt->execute();

while (($ligne = $stmt->fetch()) !== false) {
    echo "<p>{$ligne['title']}\n";
}
