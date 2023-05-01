<?php

namespace App\Model;

use PDO;

class OrderManager extends AbstractManager
{
    public const TABLE = 'order';

    public function insertOrder($userMail, $price)
    {
        $orderNumber = uniqid();
        $date = date("Y-m-d H:i");
        $status = "En cours";

        $statement = $this->pdo->prepare("
        INSERT INTO `" . self::TABLE . "` (`orderNumber`, `date`, `price`, `status`, `User_idUser`)
        SELECT :orderNumber, :date, :price, :status, `user`.`id`
        FROM `user`
        WHERE `user`.`mail` = :userMail");

        $statement->bindValue(':orderNumber', $orderNumber);
        $statement->bindValue(':date', $date);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':status', $status);
        $statement->bindValue(':userMail', $userMail);
        $statement->execute();

        return $this->pdo->lastInsertId();
    }

    public function showAllOrder(): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " 
        INNER JOIN `user` ON user.id=order.User_idUser ");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
