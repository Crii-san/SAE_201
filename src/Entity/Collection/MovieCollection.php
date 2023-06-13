<?php
declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Movie;
use PDO;

class MovieCollection
{
    /** Retourne un tableau contenant tous les films
     * @return Movie[]
     */
    public static function findAll() : array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT *
    FROM movie
    SQL
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Movie::class);
    }
}