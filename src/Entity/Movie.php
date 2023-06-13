<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class Movie
{
    protected int $id;
    protected string  $originalLanguage;
    protected string  $originalTitle;
    protected string  $overview;
    protected string  $releaseDate;
    protected int  $runtime;
    protected string  $tagline;
    protected string  $title;
    private int $posterId;

    /**
     * @return int
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }

    /**
     * @param int $posterId
     */
    public function setPosterId(int $posterId): void
    {
        $this->posterId = $posterId;
    }

    /**
     * @param int $id
     *
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /**
     * @param string $originalLanguage
     */
    public function setOriginalLanguage(string $originalLanguage): void
    {
        $this->originalLanguage = $originalLanguage;
    }

    /**
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /**
     * @param string $originalTitle
     */
    public function setOriginalTitle(string $originalTitle): void
    {
        $this->originalTitle = $originalTitle;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @param string $overview
     */
    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @param string $releaseDate
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return string
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /**
     * @param int $runtime
     */
    public function setRuntime(int $runtime): void
    {
        $this->runtime = $runtime;
    }

    /**
     * @return string
     */
    public function getTagline(): string
    {
        return $this->tagline;
    }

    /**
     * @param string $tagline
     */
    public function setTagline(string $tagline): void
    {
        $this->tagline = $tagline;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

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
