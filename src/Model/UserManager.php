<?php

namespace App\Model;

use PDO;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    /**
     * Insert new item in database
     */
    public function insertUser(array $user): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        " (firstname, lastname, address, userPassword, mail, fidelity, isAdmin, zipcode, city, phone) " .
        "VALUES (:firstname, :lastname, :address, :userPassword, :mail, :fidelity, :isAdmin, :zipcode, :city, :phone)");
        $statement->bindValue('firstname', $user['firstname'], PDO::PARAM_STR);
        $statement->bindValue('lastname', $user['lastname'], PDO::PARAM_STR);
        $statement->bindValue('address', $user['address'], PDO::PARAM_STR);
        $statement->bindValue('userPassword', $user['userPassword'], PDO::PARAM_STR);
        $statement->bindValue('mail', $user['mail'], PDO::PARAM_STR);
        $statement->bindValue('fidelity', $user['fidelity'], PDO::PARAM_STR);
        $statement->bindValue('isAdmin', $user['isAdmin'], PDO::PARAM_STR);
        $statement->bindValue('zipcode', $user['zipcode'], PDO::PARAM_STR);
        $statement->bindValue('city', $user['city'], PDO::PARAM_STR);
        $statement->bindValue('phone', $user['phone'], PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Modify a data from an user by his id
     */
    public function modifyUser($categorie, $value, $userId)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET " . $categorie . " = " . $value .
        " WHERE id = :userId");
        $statement->bindValue('userId', $userId, PDO::PARAM_STR);

        $statement->execute();
        return true;
    }

    /**
     * Delete an user by his id
     */
    public function deleteUser($userId)
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id = :userId");
        $statement->bindValue('userId', $userId, PDO::PARAM_STR);

        $statement->execute();
        return true;
    }

    /**
     * Delete a lot of users by their id
     */
    public function bulkDelete(array $ids)
    {
        foreach ($ids as $id) {
            $this->deleteUser($id);
        }
        return true;
    }

    /**
     * Search a data from a user in database by his email
     */
    public function searchUser($email, $nomCategorie)
    {
        $statement = $this->pdo->prepare("SELECT " . $nomCategorie . " FROM " . self::TABLE . " WHERE mail = :email");
        $statement->bindValue('email', $email, PDO::PARAM_STR);

        $statement->execute();
        return $statement->fetchAll();
    }

    /**
     * Search and set admin user in database by id
     */
    public function setAdmin($id, $number)
    {
        $bool = false;
        if ($number > 0) {
            $bool = true;
        }
        $this->modifyUser("isAdmin", $bool, $id);
    }

    /**
     * Phone number verification
     */
    public function phoneCheck($number)
    {
        $allowedCarac = ['0','1','2','3','4','5','6','7','8','9','.',' '];
        $numberCarac = ['0','1','2','3','4','5','6','7','8','9'];
        $counter = 0;
        foreach (str_split($number, 1) as $carac) {
            if (!in_array($carac, $allowedCarac, true)) {
                return false;
            } else {
                if (in_array($carac, $numberCarac, true)) {
                    $counter++;
                }
            }
        }
        if ($counter != 10) {
            return false;
        }
        return true;
    }
}
