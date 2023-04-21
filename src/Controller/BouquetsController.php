<?php

namespace App\Controller;

use App\Model\CatalogManager;

class BouquetsController extends AbstractController
{
    public function nosBouquets(): string
    {
        $catalogManager = new CatalogManager();
        $bouquets = $catalogManager->showBouquet();

        return $this->twig->render('Bouquets/nosBouquets.html.twig', ['bouquets' => $bouquets]);
    }
}
