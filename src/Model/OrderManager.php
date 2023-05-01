<?php

namespace App\Model;

use PDO;

class OrderManager extends AbstractManager
{
    public const ORDER = 'order';
    public const USER = 'user';

    public function addOrder(array $order): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::ORDER . " (
        `orderNumber`,
        `date`,
        `price`,
        `status`,
        VALUES (:orderNumber, 
        :date, 
        :price, 
        :status)");
        $statement->bindValue('orderNumber', $order['orderNumber'], PDO::PARAM_INT);
        $statement->bindValue('date', $order['date'], PDO::PARAM_STR);
        $statement->bindValue('price', $order['price'], PDO::PARAM_INT);
        $statement->bindValue('status', $order['status'], PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function showAllOrder(): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::ORDER . " 
        INNER JOIN " . self::USER . " ON user.id=order.User_idUser ");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
