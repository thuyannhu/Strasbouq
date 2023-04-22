<?php

namespace App\Controller;

class BouquetsController extends AbstractController
{
    public function nosBouquets(): string
    {
        return $this->twig->render('Bouquets/nosBouquets.html.twig');
    }
}
