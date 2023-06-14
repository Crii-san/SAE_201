<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;
/**
 * Class Actor : définit un film d'après la table cutron01_people.
 */
class Actor
{
    /**identifiant de l'acteur*/
    protected int $id;
    /**nom de l'acteur*/
    protected string $name;
    /**date de naissance de l'acteur*/
    protected string|null $birthday;
    /**lieu de naissance de l'acteur*/
    protected string|null $placeOfBirth;
    /**biographie de l'acteur*/
    protected string $biography;
    /**date de mort de l'acteur*/
    protected string|null $deathday;
    /**identifiant de l'avatar de l'acteur*/
    protected int|null $avatarId;

    /** Constructeur de la classe Actor. Ce constructeur créer une instance d'acteur
     * @param int $id
     * @param string $name
     * @param string|null $birthday
     * @param string|null $placeOfBirth
     * @param string $biography
     * @param string|null $deathday
     * @param int|null $avatarId
     */
    public function __construct(int $id, string $name, string|null $birthday, string|null $placeOfBirth, string $biography, string|null $deathday, int|null $avatarId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthday = $birthday;
        $this->placeOfBirth = $placeOfBirth;
        $this->biography = $biography;
        $this->deathday = $deathday;
        $this->avatarId = $avatarId;
    }

    /** renvois l'identifiant de l'avatar
     * @return int
     */
    public function getAvatarId(): int|null

    {
        return $this->avatarId;
    }

    /** change l'identifiant de l'avatar
     * @param int $avatarId
     */
    public function setAvatarId(int $avatarId): void
    {
        $this->avatarId = $avatarId;
    }

    /** renvois la biography de l'acteur
     * @return string
     */
    public function getBiography(): string
    {
        return $this->biography;
    }

    /** change la biography de l'acteur
     * @param string $biography
     */
    public function setBiography(string $biography): void
    {
        $this->biography = $biography;
    }

    /** renvois le lieu de naissance de l'acteur
     * @return string
     */
    public function getBirthPlace(): string|null
    {
        return $this->placeOfBirth;
    }

    /** change le lieu de naissance de l'acteur
     * @param string $birthPlace
     */
    public function setBirthPlace(string $placeOfBirth): void
    {
        $this->placeOfBirth = $placeOfBirth;
    }

    /** renvois la date de mort de l'acteur
     * @return string
     */
    public function getDeathday(): string|null
    {
        return $this->deathday;
    }

    /** change la date de mort de l'acteur
     * @param string $deathday
     */
    public function setDeathday(string $deathday): void
    {
        $this->deathday = $deathday;
    }


    /** renvois la date de naissance de l'acteur
     * @return string
     */
    public function getBirthday(): string|null
    {
        return $this->birthday;
    }

    /** change la date de naissance de l'acteur
     * @param string $birthday
     */
    public function setBirthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }

    /** renvois l'id de l'acteur
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** change l'id de l'acteur
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }


    /** renvois le nom de l'acteur
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /** change le nom de l'acteur
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /** renvois le lieu de naissance de l'acteur
     * @return string
     */
    public function getPlaceOfBirth(): string
    {
        return $this->placeOfBirth;
    }

    /** change le lieu de naissance de l'acteur
     * @param string $placeOfBirth
     */
    public function setPlaceOfBirth(string $placeOfBirth): void
    {
        $this->placeOfBirth = $placeOfBirth;
    }

    /** créer une instance d'acteur à l'aide de son id
     * @param int $id
     * @return Actor
     */
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
