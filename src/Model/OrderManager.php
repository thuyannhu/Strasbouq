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
        $statement = $this->pdo->prepare("SELECT `order`.`id`,
         `order`.`orderNumber`,
         `order`.`date`,
         `user`.`lastname`,
         `user`.`zipcode`,
         `user`.`city`,
         `user`.`phone`,
         `user`.`mail`,
         `order`.`price`,
         `order`.`status`,
         `user` . `isAdmin`
        FROM `" . self::TABLE . "` 
        INNER JOIN `user` ON `user`.`id` = `" . self::TABLE . "`.`User_idUser`");

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function showOrderByUser(string $user): array
    {
        $statement = $this->pdo->prepare("SELECT `order`.`id`,
     `order`.`orderNumber`,
     `order`.`date`,
     `order`.`price`,
     `order`.`status`,
     `user` . `isAdmin`
    FROM `" . self::TABLE . "` 
    INNER JOIN `user` ON `user`.`id` = `" . self::TABLE . "`.`User_idUser`
    WHERE `user`.`mail` = :userMail");

        $statement->execute(['userMail' => $user]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrderStatus($id, $status)
    {
        $statement = $this->pdo->prepare("UPDATE `" . self::TABLE . "` SET status=:status WHERE id=:id");
        $statement->bindValue(':id', $id);
        $statement->bindValue(':status', $status);
        $statement->execute();
    }

    public function deleteOrder($id)
    {
        $statement = $this->pdo->prepare("DELETE FROM `" . self::TABLE . "` WHERE id=:id");
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
}
