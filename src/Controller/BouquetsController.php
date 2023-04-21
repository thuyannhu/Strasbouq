<?php

namespace App\Controller;

use App\Model\CatalogManager;

class BouquetsController extends AbstractController
{
    public function nosBouquets(): string
    {
        $catalogManager = new CatalogManager();
        $products = $catalogManager->showCatalogue();

        return $this->twig->render('Bouquets/nosBouquets.html.twig', ['products' => $products]);
    }
}
