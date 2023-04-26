<?php

namespace App\Controller;

use App\Model\CatalogManager;

class BouquetsController extends AbstractController
{
    public function filterBouquet()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $catalogManager = new CatalogManager();
            $color = $_POST['color'];
            $resultFilter = $catalogManager->filterColor($color);
            return $resultFilter;
        } else {
            return [];
        }
    }

    public function addToCart()
    {
        if (isset($_GET['add_to_cart'])) {
            $id = $_GET['add_to_cart'];
            $catalogManager = new CatalogManager();
            $product = $catalogManager->getProductById($id);
            if ($product) {
                $name = $product['name'];
                $price = $product['price'];
                if (isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id]['quantity']++;
                } else {
                    $_SESSION['cart'][$id] = [
                        'quantity' => 1,
                        'name' => $name,
                        'price' => $price
                    ];
                }
            }
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }


    public function nosBouquets(): string
    {
        $catalogManager = new CatalogManager();
        $resultFilter = $this->filterBouquet();
        $bouquets = [];
        if ($resultFilter) {
            $bouquets = $resultFilter;
        } else {
            $bouquets = $catalogManager->showBouquet();
        }

        if (isset($_GET['add_to_cart'])) {
            $this->addToCart();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        var_dump($_SESSION);
        return $this->twig->render('Bouquets/nosBouquets.html.twig', ['bouquets' => $bouquets]);
    }
}
