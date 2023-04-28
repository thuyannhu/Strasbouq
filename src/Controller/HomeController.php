<?php

namespace App\Controller;

use App\Model\ProductManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $productManager = new ProductManager();
        $productImage = $productManager->selectAllImages('images.Products_idProducts');

        return $this->twig->render('Home/index.html.twig', ['images' => $productImage]);
    }
}
