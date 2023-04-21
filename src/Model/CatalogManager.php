<?php

namespace App\Model;

use PDO;

class CatalogManager extends AbstractManager
{
    public const TABLE = 'products';

    public function showCatalogue():array
    {
    $statement = $this->pdo->prepare("SELECT name, description, price FROM " . self::TABLE . "");
    $statement->execute();
    $productName = $statement->fetchAll();
    return $productName;
    }

}

