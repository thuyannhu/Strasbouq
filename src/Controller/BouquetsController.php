<?php

namespace App\Controller;

use App\Model\CatalogManager;

class BouquetsController extends AbstractController
{
    public function filterBouquet()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $catalogManager = new CatalogManager();
            $resultFilter = $catalogManager->filterColor();
            return $resultFilter;
        } else {
            return [];
        }
    }

    public function nosBouquets(): string
    {
        $catalogManager = new CatalogManager();
        $resultFilter = $this->filterBouquet();
        $bouquets = [];
        if ($resultFilter) {
            $bouquets = $resultFilter;
        } else {
            $bouquets = $catalogManager->showBouquet();
        }

        return $this->twig->render('Bouquets/nosBouquets.html.twig', ['bouquets' => $bouquets]);
    }
}
