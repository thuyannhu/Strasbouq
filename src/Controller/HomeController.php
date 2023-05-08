<?php

namespace App\Controller;

use App\Model\ProductManager;
use App\Controller\BouquetsController;
use App\Controller\ImageController;

class HomeController extends AbstractController
{
    // Selects all products, their first image and adds to cart when icon is clicked
    public function index(): string
    {
        //Selects all products and all images
        $productManager = new ProductManager();
        $productImage = $productManager->selectAllImages();

        // If icon is clicked, product is added to cart
        $bouquetsController = new BouquetsController();
        if (isset($_GET['add_to_cart'])) 
        {
            $bouquetsController->addToCart();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $imageController = new ImageController();
        $newImage = $imageController->imageDuplicate($productImage);

        return $this->twig->render('Home/index.html.twig', ['images' => $newImage]);
    }
}

