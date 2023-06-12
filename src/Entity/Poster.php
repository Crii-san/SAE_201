<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Poster
{
    private int $id;
    private string $jpeg;

    /** Accesseur à l'id du poster
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Accesseur à l'image du poster
     * @return string
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /** Permet de retrouver le poster correspondant à l'id de l'artiste en paragraphe.
     * @param int $id Identifiant de l'artiste
     * @return Poster
     */
    public static function findById(int $id): Poster
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
        SELECT id, jpeg
        FROM image
        WHERE id = :id
        SQL
        );
        $stmt->execute([':id' => $id]);
        $stmt ->setFetchMode(PDO::FETCH_CLASS, Poster::class);
        $res = $stmt->fetch();

        if ($res!==false) {
            return $res;
        }
        throw new EntityNotFoundException("Aucun cover trouvé avec cet id");
    }
}
