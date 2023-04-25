<?php

namespace App\Controller;

use App\Model\ProductManager;
use App\Service\Image;
use App\Model\ImageManager;
use App\Controller\ImageController;

class ProductController extends AbstractController
{
    public function index(): string
    {
        $productManager = new ProductManager();
        $productImage = $productManager->selectAllImages('images.Products_idProducts');
        var_dump($_POST);
        
        return $this->twig->render('Product/index.html.twig', ['images' => $productImage]);
    }

    public function show(int $id): string
    {   
        $productManager = new ProductManager();
        $product = $productManager->selectOneById($id);
        $productImage = $productManager->selectOneByIdByImages($id);
        return $this->twig->render('Product/show.html.twig', ['product' => $product, 'image' => $productImage]);
    }

    public function add(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = array_map('trim', $_POST);
            $productManager = new ProductManager();
            $id = $productManager->insert($product);

            $image = new ImageController();
            $image->addImage($_FILES, $id);
            header('Location: /products/show?id=' . $id);
            return null;
        }
        return $this->twig->render('Product/add.html.twig');
    }
    public function edit(int $id): ?string
    {
        
        $productManager = new ProductManager();
        $product = $productManager->selectOneById($id);

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $productManager->update($product);

            header('Location: /products/show?id=' . $id);

            return null;
        }

        return $this->twig->render('product/edit.html.twig', [
            'product' => $product
        ]);
    }

    public function delete(): void
    {   
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $productManager = new ProductManager();
            $productManager->deleteProducts((int)$id);
            header('Location:/products');
        }
    }

    
}
