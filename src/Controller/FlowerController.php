<?php

namespace App\Controller;

use App\Model\CatalogManager;

class FlowerController extends AbstractController
{
    public function flower(): string
    {
        return $this->twig->render('Bouquets/flower.html.twig');
    }
}
