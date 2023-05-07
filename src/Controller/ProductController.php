<?php

namespace App\Controller;

use App\Model\ProductManager;
use App\Service\Image;
use App\Model\ImageManager;
use App\Controller\ImageController;
use App\Controller\BouquetsController;

class ProductController extends AbstractController
{
    // Displays all products with their first image
    public function index(): string
    {
        // Selects all products with all their images
        $productManager = new ProductManager();
        $productImage = $productManager->selectAllImages('images.Products_idProducts');

        // Checks if product image id is the same as the precedent one to avoid duplicate image
        $newImage = [];
        $precedent = 0;
        foreach ($productImage as $image) {
            if ($image['Products_idProducts'] != $precedent) {
                $newImage[] = $image;
            }
            $precedent = $image['Products_idProducts'];
        }

        return $this->twig->render('Product/index.html.twig', ['images' => $newImage]);
    }

    // Displays product with chosen $id with all images
    public function show(int $id): string
    {
        // Selects chosen product data
        $productManager = new ProductManager();
        $productImage = $productManager->selectOneByIdByImages($id);

        // Selects chosen product image data
        $imageManager = new ImageManager();
        $images = $imageManager ->selectImages($id);


        // If icon is clicked, product is added to cart
        $bouquetsController = new BouquetsController();

        if (isset($_GET['add_to_cart'])) {
            $bouquetsController->addToCart();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        return $this->twig->render(
            'Product/show.html.twig',
            ['product' => $productImage, 'images' => $images, 'id' => $id]
        );
    }

    // Adds a new product in db
    public function add(): ?string
    {
        $message = [];
        // Checks if form data is compliant
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->globalCheck();

            if (empty($errors)) {
                $product = array_map('trim', $_POST);

                // Inserts product data in db
                $productManager = new ProductManager();
                $id = $productManager->insert($product);

                // Inserts image data in db
                $image = new ImageController();
                $image->addImage($_FILES, $id);


                header('Location: /products/show?id=' . $id);
                return null;
            } else {
                $message = $this->addErrorsToMessage($errors, $message);
            }
        }
        return $this->twig->render('Product/add.html.twig', ['message' => $message]);
    }

    // Modify product with chosen $id
    public function edit(int $id): ?string
    {
        // Selects chosen product data
        $productManager = new ProductManager();
        $product = $productManager->selectOneByIdByImages($id);

        // Checks if form data is compliant
        $message = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->globalCheck();


            if (empty($errors)) {
                $product = array_map('trim', $_POST);

                // Updates product data in db
                $productManager->update($product);

                // Inserts new image in db
                $image = new ImageController();
                $image->addImage($_FILES, $id);

                header('Location: /products/show?id=' . $id);
                return null;
            } else {
                $message = $this->addErrorsToMessage($errors, $message);
            }
        }

        return $this->twig->render(
            'product/edit.html.twig',
            ['product' => $product, 'message' => $message, 'id' => $id]
        );
    }

    // Deletes product with chosen $id
    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $productManager = new ProductManager();
            $productManager->deleteProducts((int)$id);
            header('Location:/products');
        }
    }

    // Adds product with chosen $id to homepage "Trending products" display
    public function trending(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $productManager = new ProductManager();
            $productManager->addTrending((int)$id);
            header('Location:/products');
        }
    }

    // Translates form fields name in French
    private function translate($input)
    {
        $translated = [
            "name" => "Le nom", "description" => "La description", "price" => "Le prix",
            "inventory" => "Le stock", "color" => "La couleur", "category" => "La catégorie",
            "size" => "L'image"
        ];
        return $translated[$input];
    }

    // Checks if a firm field has been filed, else adds an error message
    private function checkInput($input, $errors)
    {
        if (!isset($_POST[$input]) || trim($_POST[$input]) === '') {
            $errors[$input] = $this->translate($input) . " est obligatoire.";
        }
        return $errors;
    }

    // Checks if an image has been added to form, else adds an error message
    private function checkImage($input, $errors)
    {
        if (!isset($_FILES['image'][$input]) || trim($_FILES['image'][$input]) === '') {
            $errors[$input] = $this->translate($input) . " est obligatoire.";
        }
        return $errors;
    }

    // Implement checks on all form fields
    private function globalCheck()
    {
        $errors = [];
        $errors = $this->checkInput('name', $errors);
        $errors = $this->checkInput('description', $errors);
        $errors = $this->checkInput('price', $errors);
        $errors = $this->checkInput('inventory', $errors);
        $errors = $this->checkInput('color', $errors);
        $errors = $this->checkInput('category', $errors);
        $errors = $this->checkImage('size', $errors);
        return $errors;
    }

    // Stacks errors in $message
    private function addErrorsToMessage($errors, $message)
    {
        foreach ($errors as $error) {
            array_push($message, $error);
        }
        return $message;
    }
}
