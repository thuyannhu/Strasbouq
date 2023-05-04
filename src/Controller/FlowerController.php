<?php

namespace App\Controller;

use App\Model\CatalogManager;
use App\Controller\BouquetsController;
use App\Controller\CartController;

class FlowerController extends AbstractController
{
    public function filterFlower()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $catalogManager = new CatalogManager();
            $color = $_POST['color'];
            $resultFilter = $catalogManager->filterFlowerColor($color);
            return $resultFilter;
        } else {
            return [];
        }
    }

    public function flowers(): string
    {
        $catalogManager = new CatalogManager();
        $resultFilter = $this->filterFlower();
        $flowers = [];
        if ($resultFilter) {
            $flowers = $resultFilter;
        } else {
            $flowers = $catalogManager->showFlowers();
        }

        if (isset($_GET['add_to_cart'])) {
            $bouquetsController = new BouquetsController();
            $bouquetsController->addToCart();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        return $this->twig->render('Bouquets/flower.html.twig', ['flowers' => $flowers]);
    }
}
