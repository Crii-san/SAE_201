<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;
/**
 * Class Movie : définit un film d'après la table cutron01_movie.
 */
class Movie
{
    /**identifiant*/
    protected int $id;
    /**Langue d'origine du film*/
    protected string  $originalLanguage;
    /**Titre d'origine du film*/
    protected string  $originalTitle;
    /**Résumé du film*/
    protected string  $overview;
    /**Date de sortie du film*/
    protected string  $releaseDate;
    /**Durée du film*/
    protected int  $runtime;
    /**Slogan du film*/
    protected string  $tagline;
    /**Titre en france du film*/
    protected string  $title;
    /**Identifiant du poster du film*/
    private int $posterId;

    /**
     * renvois l'identifiant du poster du film
     * @return int
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }

    /**
     * ajoute/change la valeur de l'identifiant du poster du film
     * @param int $posterId
     */
    public function setPosterId(int $posterId): void
    {
        $this->posterId = $posterId;
    }

    /** Constructeur de la classe Movie. Ce constructeur créer une instance de film
     * @param int $id
     * @param string $originalLanguage
     * @param string $originalTitle
     * @param string $overview
     * @param string $releaseDate
     * @param int $runtime
     * @param string $tagline
     * @param string $title
     */
    public function __construct(int $id, int $posterId, string $originalLanguage, string $originalTitle, string $overview, string $releaseDate, int $runtime, string $tagline, string $title)
    {
        $this->id = $id;
        $this->posterId = $posterId;
        $this->originalLanguage = $originalLanguage;
        $this->originalTitle = $originalTitle;
        $this->overview = $overview;
        $this->releaseDate = $releaseDate;
        $this->runtime = $runtime;
        $this->tagline = $tagline;
        $this->title = $title;
    }

    /** renvois l'identifiant du film
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** renvois le language d'origine du film
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /** change le language d'origine du film
     * @param string $originalLanguage
     */
    public function setOriginalLanguage(string $originalLanguage): void
    {
        $this->originalLanguage = $originalLanguage;
    }

    /** renvois le titre d'origine du film
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /** change le titre d'origine du film
     * @param string $originalTitle
     */
    public function setOriginalTitle(string $originalTitle): void
    {
        $this->originalTitle = $originalTitle;
    }

    /** renvois le résumé du film
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /** change le résumé du film
     * @param string $overview
     */
    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /** renvois la date de sortie du film
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /** change la date de sortie du film
     * @param string $releaseDate
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /** renvois la durée du film
     * @return string
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /** change la durée du film
     * @param int $runtime
     */
    public function setRuntime(int $runtime): void
    {
        $this->runtime = $runtime;
    }

    /** renvois le slogan du film
     * @return string
     */
    public function getTagline(): string
    {
        return $this->tagline;
    }

    /** change le slogan du film
     * @param string $tagline
     */
    public function setTagline(string $tagline): void
    {
        $this->tagline = $tagline;
    }

    /** renvois le titre du film
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /** change le titre du film
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /** change l'identifiant du film
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /** créer une instance de film à l'aide de son id
     * @param int $id
     * @return Movie
     */
    public static function findById($id): Movie
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
        $movie = new Movie($res['id'], $res['posterId'], $res['originalLanguage'], $res['originalTitle'], $res['overview'], $res['releaseDate'], $res['runtime'], $res['tagline'], $res['title']);

        return $movie;
    }
}
