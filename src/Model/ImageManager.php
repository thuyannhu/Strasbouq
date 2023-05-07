<?php

namespace App\Model;

use PDO;

class ImageManager extends AbstractManager
{
    public const TABLE = 'images';

    // Inserts image name and id in db
    public function insert(string $image, int $productId): int
    {
        $statement = $this->pdo->prepare("INSERT INTO images (`filename`, `products_idProducts`) 
        VALUES (:filename, :productsId)");
        $filename = $image;
        $productsId = $productId;
        $statement->bindValue('filename', $filename, PDO::PARAM_STR);
        $statement->bindValue('productsId', $productsId, PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    // Selects image with chosen $id
    public function selectImages(int $id)
    {
        $statement = $this->pdo->prepare("SELECT filename FROM images WHERE Products_idProducts =:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
