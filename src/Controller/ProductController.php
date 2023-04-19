<?php

namespace App\Controller;

use App\Model\ProductManager;

class ProductController extends AbstractController
{
    public function index(): string
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll('name');

        return $this->twig->render('Product/index.html.twig', ['products' => $products]);
    }

    public function show(int $id): string
    {
        $productManager = new ProductManager();
        $product = $productManager->selectOneById($id);

        return $this->twig->render('Product/show.html.twig', ['product' => $product]);
    }

    public function add(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = array_map('trim', $_POST);
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $authorizedExtensions = ['jpg','jpeg','png'];
            $maxFileSize = 1000000;

            if (in_array($extension, $authorizedExtensions)) {
                $errors = [];
                $uploadDir = 'uploads/';
                $uploadFile = $uploadDir . uniqid() . '.' . $extension;

                if ($_FILES['image']['size'] > $maxFileSize) {
                    $errors[] = "Votre fichier doit faire moins de 2M !";
                }

                if (empty($errors)) {
                    move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);
                    $productManager = new ProductManager();
                    $id = $productManager->insert($product);
                    header('Location: /products/show?id=' . $id);
                }

                if ($errors) {
                    foreach ($errors as $error) {
                        echo "<p>" . $error . "</p>";
                    }
                }
            }
        }
        return $this->twig->render('Product/add.html.twig');
    }
}
