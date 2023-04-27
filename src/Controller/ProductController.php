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

        return $this->twig->render('Product/index.html.twig', ['images' => $productImage]);
    }

    public function show(int $id): string
    {
        $productManager = new ProductManager();
        $productImage = $productManager->selectOneByIdByImages($id);
        return $this->twig->render('Product/show.html.twig', ['product' => $productImage]);
    }

    public function showsheet(int $id): string
    {
        $productManager = new ProductManager();
        $productImage = $productManager->selectOneByIdByImages($id);
        return $this->twig->render('Product/showsheet.html.twig', ['product' => $productImage]);
    }

    public function add1(): ?string
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


    public function add(): ?string
    {
        $message = [];
        $alert = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $errors = $this->globalCheck();

            if (empty($errors)) {
            $product = array_map('trim', $_POST);
            $productManager = new ProductManager();
            $id = $productManager->insert($product);

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

    public function edit(int $id): ?string
    {
        $productManager = new ProductManager();
        $product = $productManager->selectOneByIdByImages($id);
        $message = [];
        $alert = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $errors = $this->globalCheck();

            if (empty($errors)) {
            $product = array_map('trim', $_POST);
            $productManager->update($product);
            header('Location: /products/show?id=' . $id);
        } else {
            $message = $this->addErrorsToMessage($errors, $message);
        }    
    }

        return $this->twig->render('product/edit.html.twig', ['product' => $product, 'message' => $message]);
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

    private function translate($input)
    {
        $translated = [
            "name" => "Le nom", "description" => "La description", "price" => "Le prix",
            "inventory" => "Le stock", "color" => "La couleur", "category" => "La catégorie",
            "size" => "L'image"
        ];
        return $translated[$input];
    }

    private function checkInput($input, $errors)
    {
        if (!isset($_POST[$input]) || trim($_POST[$input]) === '') {
            $errors[$input] = $this->translate($input) . " est obligatoire.";
        }
        return $errors;
    }

    private function checkImage($input, $errors)
    {
        if (!isset($_FILES['image'][$input]) || trim($_FILES['image'][$input]) === '') {
            $errors[$input] = $this->translate($input) . " est obligatoire.";
        }
        return $errors;
    }

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

    private function addErrorsToMessage($errors, $message)
    {
        foreach ($errors as $error) {
            array_push($message, $error);
        }
        return $message;
    }
}
