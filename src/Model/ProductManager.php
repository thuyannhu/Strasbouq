<?php

namespace App\Model;

use PDO;

class ProductManager extends AbstractManager
{
    public const TABLE = 'products';
    public function insert(array $product): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (
        `name`,
        `description`,
        `price`,
        `inventory`,
        `color`,
        `category`) 
        VALUES (:name, 
        :description, 
        :price, 
        :inventory, 
        :color, 
        :category)");
        $statement->bindValue('name', $product['name'], PDO::PARAM_STR);
        $statement->bindValue('description', $product['description'], PDO::PARAM_STR);
        $statement->bindValue('price', $product['price'], PDO::PARAM_INT);
        $statement->bindValue('inventory', $product['inventory'], PDO::PARAM_INT);
        $statement->bindValue('color', $product['color'], PDO::PARAM_STR);
        $statement->bindValue('category', $product['category'], PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
    
}
