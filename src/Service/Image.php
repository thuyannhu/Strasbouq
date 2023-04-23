<?php

namespace App\Service;

class Image {

    public function upload(array $file)
    {
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $uploadDir = 'assets/img/products/';
        $uploadFile = $uploadDir . uniqid() . '.' . $extension;
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);
        return $uploadFile;
    }
}
