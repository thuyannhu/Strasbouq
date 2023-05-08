<?php

namespace App\Controller;

use App\Model\ImageManager;
use App\Service\Image;

class ImageController extends AbstractController
{
    public function addImage($image, $productId): ?string
    {
        $authorizedExtensions = ['jpg','jpeg','png'];
        $maxFileSize = 5000000;
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_FILES['image']['size'] > $maxFileSize) {
                $errors[] = "Votre fichier doit faire moins de 5 Mo !";
            }
            if ((!in_array($extension, $authorizedExtensions))) {
                $errors[] = "Veuillez sélectionner une image de type Jpg ou Jpeg ou Png !";
            }
            if (!$errors) {
                $image = new Image();
                $newImage = $image->upload();
                $imageManager = new ImageManager();
                $id = $imageManager->insert($newImage, $productId);
                header('Location:/products/show?id=' . $id);
                return null;
            }
        } return $this->twig->render('Product/add.html.twig');
    }
}
