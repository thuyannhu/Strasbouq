<?php

namespace App\Model;

use PDO;

class ProductManager extends AbstractManager
{
    public const TABLE = 'products';

    // Selects all products and all their images
    public function selectAllImages(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = "SELECT * FROM " . static::TABLE . " INNER JOIN 
        images ON products.id=images.Products_idProducts";
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }
        return $this->pdo->query($query)->fetchAll();
    }

    // Selects chosen product data
    public function selectOneByIdByImages(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " INNER JOIN 
        images ON products.id=images.Products_idProducts WHERE products.id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    // Inserts products data in db
    public function insert(array $product): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (
        `name`,
        `description`,
        `price`,
        `inventory`,
        `color`,
        `category`,
        `isTrending`) 
        VALUES (:name, 
        :description, 
        :price, 
        :inventory, 
        :color, 
        :category,
        :isTrending)");
        $statement->bindValue('name', $product['name'], PDO::PARAM_STR);
        $statement->bindValue('description', $product['description'], PDO::PARAM_STR);
        $statement->bindValue('price', $product['price'], PDO::PARAM_INT);
        $statement->bindValue('inventory', $product['inventory'], PDO::PARAM_INT);
        $statement->bindValue('color', $product['color'], PDO::PARAM_STR);
        $statement->bindValue('category', $product['category'], PDO::PARAM_STR);
        $statement->bindValue('isTrending', $product['isTrending'], PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    // Modifies product data in db
    public function update(array $product): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET 
        `name` = :name,
        `description` = :description,
        `price` = :price,
        `inventory` = :inventory,
        `color` = :color,
        `category` = :category,
        `isTrending` = :isTrending
         WHERE id=:id");
        $statement->bindValue('id', $product['id'], PDO::PARAM_INT);
        $statement->bindValue('name', $product['name'], PDO::PARAM_STR);
        $statement->bindValue('description', $product['description'], PDO::PARAM_STR);
        $statement->bindValue('price', $product['price'], PDO::PARAM_INT);
        $statement->bindValue('inventory', $product['inventory'], PDO::PARAM_INT);
        $statement->bindValue('color', $product['color'], PDO::PARAM_STR);
        $statement->bindValue('category', $product['category'], PDO::PARAM_STR);
        $statement->bindValue('isTrending', $product['isTrending'], PDO::PARAM_INT);

        return $statement->execute();
    }

    // Deletes product with chosen $id from db
    public function deleteProducts(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE products FROM " . static::TABLE . " INNER JOIN 
        images ON products.id=images.Products_idProducts WHERE products.id=:id");

        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        $statement->execute();
    }

    // Changes product with chosen id "isTrending" value to 1
    public function addTrending(int $id): void
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " INNER JOIN 
        images ON products.id=images.Products_idProducts SET isTrending = 1 WHERE products.id=:id");

        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        $statement->execute();
    }

     // Changes product with chosen id "isTrending" value to 0
    public function removeTrending(int $id): void
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " INNER JOIN 
         images ON products.id=images.Products_idProducts SET isTrending = 0 WHERE products.id=:id");

        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        $statement->execute();
    }
}
