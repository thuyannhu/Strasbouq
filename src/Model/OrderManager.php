<?php

namespace App\Model;

use PDO;

class OrderManager extends AbstractManager
{
    public const ORDER = 'order';
    public const PRODUCTS = 'products';
    public const USER = 'user';

    public function addOrder(array $order): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::ORDER . " (
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
        $statement->bindValue('name', $order['name'], PDO::PARAM_STR);
        $statement->bindValue('description', $order['description'], PDO::PARAM_STR);
        $statement->bindValue('price', $order['price'], PDO::PARAM_INT);
        $statement->bindValue('inventory', $order['inventory'], PDO::PARAM_INT);
        $statement->bindValue('color', $order['color'], PDO::PARAM_STR);
        $statement->bindValue('category', $order['category'], PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
