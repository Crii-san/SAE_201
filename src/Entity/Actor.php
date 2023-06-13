<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class Actor
{
    protected int $id;
    protected string $name;
    protected string $birthday;
    protected string $placeOfBirth;
    protected string $biography;
    protected string|null $deathday;
    protected int $avatarId;

    public function __construct(int $id, string $name, string $birthday, string $placeOfBirth, string $biography, string|null $deathday, int $avatarId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthday = $birthday;
        $this->placeOfBirth = $placeOfBirth;
        $this->biography = $biography;
        $this->deathday = $deathday;
        $this->avatarId = $avatarId;
    }

    /**
     * @return int
     */
    public function getAvatarId(): int
    {
        return $this->avatarId;
    }

    /**
     * @param int $avatarId
     */
    public function setAvatarId(int $avatarId): void
    {
        $this->avatarId = $avatarId;
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
    public function getDeathday(): string
    {
        return $this->deathday;
    }

    /**
     * @param string $deathday
     */
    public function setDeathday(string $deathday): void
    {
        $this->deathday = $deathday;
    }

    /**
     * @return int
     */
    public function getInt(): int
    {
        return $this->int;
    }

    /**
     * @param int $int
     */
    public function setInt(int $int): void
    {
        $this->int = $int;
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
    public function getPlaceOfBirth(): string
    {
        return $this->placeOfBirth;
    }

    /**
     * @param string $placeOfBirth
     */
    public function setPlaceOfBirth(string $placeOfBirth): void
    {
        $this->placeOfBirth = $placeOfBirth;
    }

    public static function findById($id): Actor
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
        SELECT *
        FROM people
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
        $movie = new Actor($res['id'], $res['name'], $res['birthday'], $res['placeOfBirth'], $res['biography'], $res['deathday'], $res['avatarId']);

        return $movie;
    }
}
