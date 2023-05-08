<?php

namespace App\Controller;

use App\Model\ProductManager;
use App\Controller\BouquetsController;

class HomeController extends AbstractController
{
    // Selects all products, their first image and adds to cart when icon is clicked
    public function index(): string
    {
        $productManager = new ProductManager();
        $bouquetsController = new BouquetsController();

        //Selects all products and all images
        $productImage = $productManager->selectAllImages();

        // If icon is clicked, product is added to cart
        if (isset($_GET['add_to_cart'])) {
            $bouquetsController->addToCart();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $newImage = [];
        $precedent = 0;

        // Checks if product image id is the same as the precedent one to avoid duplicate image
        foreach ($productImage as $image) {
            if ($image['Products_idProducts'] != $precedent) {
                $newImage[] = $image;
            }
            $precedent = $image['Products_idProducts'];
        }

        return $this->twig->render('Home/index.html.twig', ['images' => $newImage]);
    }
}
