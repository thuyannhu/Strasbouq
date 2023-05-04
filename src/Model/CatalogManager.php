<?php

namespace App\Model;

use PDO;

class CatalogManager extends AbstractManager
{
    public const TABLE = 'products';

    public function showCatalogue(): array
    {
        $statement = $this->pdo->prepare("SELECT id, name, description, price FROM " . self::TABLE . "");
        $statement->execute();
        $productCatalog = $statement->fetchAll();
        return $productCatalog;
    }

    public function showBouquets(): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " 
        LEFT JOIN images ON products.id=images.Products_idProducts 
        WHERE category = 'bouquet'");
        $statement->execute();
        $allBouquets = $statement->fetchAll();
        return $allBouquets;
    }

    public function filterBouquetColor($color): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " 
        LEFT JOIN images ON products.id=images.Products_idProducts 
        WHERE color = :color AND category = 'bouquet'");
        $statement->bindValue(':color', $color);
        $statement->execute();
        $productFilter = $statement->fetchAll();
        return $productFilter;
    }

    public function getProductById($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " 
        LEFT JOIN images ON products.id=images.Products_idProducts
        WHERE Products_idProducts = :id");
        $statement->execute([':id' => $id]);
        $product = $statement->fetch();
        return $product;
    }
}
