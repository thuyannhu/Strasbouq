<?php

namespace App\Controller;

use App\Model\ProductManager;
use App\Controller\BouquetsController;


class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $productManager = new ProductManager();
        $bouquetsController = new BouquetsController();
        $productImage = $productManager->selectAllImages();
        if (isset($_GET['add_to_cart'])) {
            $bouquetsController->addToCart();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        return $this->twig->render('Home/index.html.twig', ['images' => $productImage]);
    }
}
