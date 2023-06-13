<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class Actor
{
    protected int $int;
    protected string $name;
    protected string $birthPlace;
    protected string $placeOfBirth;
    protected string $biography;
    protected string $deathday;
    protected int $avatarId;

    public function __construct(string $name, string $birthPlace, string $placeOfBirth, string $biography, string $deathday, int $avatarId)
    {
        $this->name = $name;
        $this->birthPlace = $birthPlace;
        $this->placeOfBirth = $placeOfBirth;
        $this->biography = $biography;
        $this->deathday = $deathday;
        $this->avatarId = $avatarId;
    }

    /**
     * @return string
     */
    public function getDeathDay(): string
    {
        return $this->deathDay;
    }

    /**
     * @param string $deathDay
     */
    public function setDeathDay(string $deathDay): void
    {
        $this->deathDay = $deathDay;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getBirthPlace(): string
    {
        return $this->birthPlace;
    }

    /**
     * @param string $birthPlace
     */
    public function setBirthPlace(string $birthPlace): void
    {
        $this->birthPlace = $birthPlace;
    }

    /**
     * @return string
     */
    public function getBirthdate(): string
    {
        return $this->Birthdate;
    }

    /**
     * @param string $Birthdate
     */
    public function setBirthdate(string $Birthdate): void
    {
        $this->Birthdate = $Birthdate;
    }

    /**
     * @return string
     */
    public function getBiography(): string
    {
        return $this->biography;
    }

    /**
     * @param string $biography
     */
    public function setBiography(string $biography): void
    {
        $this->biography = $biography;
    }

    public static function findById($id): Actor
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
        SELECT *
        FROM movie
        WHERE id = :id
        SQL
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$res) {
            http_response_code(404);
            exit();
        }
        $movie = new Actor();

        return $movie;
    }
}
