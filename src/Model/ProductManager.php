<?php

namespace App\Model;

use PDO;

class ProductManager extends AbstractManager
{
    public const TABLE = 'products';

    public function selectAllImages(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = "SELECT * FROM " . static::TABLE . " LEFT JOIN 
        images ON products.id=images.Products_idProducts";
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }
        return $this->pdo->query($query)->fetchAll();
    }

    public function selectOneByIdByImages(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " INNER JOIN 
        images ON products.id=images.Products_idProducts WHERE products.id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

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

    public function update(array $product): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET 
        `name` = :name,
        `description` = :description,
        `price` = :price,
        `inventory` = :inventory,
        `color` = :color,
        `category` = :category,
        `isTrending`=:isTrending
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

    public function deleteProducts(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE products FROM " . static::TABLE . " INNER JOIN 
        images ON products.id=images.Products_idProducts WHERE products.id=:id");

        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        $statement->execute();
    }
}
