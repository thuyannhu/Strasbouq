<?php

namespace App\Model;

use PDO;

class CatalogManager extends AbstractManager
{
    public const TABLE = 'products';

    public function showCatalogue(): array
    {
        $statement = $this->pdo->prepare("SELECT name, description, price FROM " . self::TABLE . "");
        $statement->execute();
        $productCatalog = $statement->fetchAll();
        return $productCatalog;
    }

    public function showBouquet(): array
    {
        $statement = $this->pdo->prepare("SELECT name, description, price 
        FROM " . self::TABLE . " WHERE category = :category");
        $statement->bindValue(':category', 'bouquet');
        $statement->execute();
        $productBouquet = $statement->fetchAll();
        return $productBouquet;
    }

    public function filterColor($color): array
    {
        $statement = $this->pdo->prepare("SELECT name, description, price 
        FROM " . self::TABLE . " WHERE color = :color");
        $statement->bindValue(':color', $color);
        $statement->execute();
        $productFilter = $statement->fetchAll();
        return $productFilter;
    }
}
