<?php

namespace App\Model;

use PDO;

class ImageManager extends AbstractManager
{
    public const TABLE = 'images';
    public function insert(string $image, int $productId): int
    {
        $statement = $this->pdo->prepare("INSERT INTO images (`filename`, `Products_idProducts`) VALUES (:filename, :Products_idProducts)");
        $filename = $image;
        $Products_idProducts = $productId;
        $statement->bindValue('filename', $filename, PDO::PARAM_STR);
        $statement->bindValue('Products_idProducts', $Products_idProducts, PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
    
}
