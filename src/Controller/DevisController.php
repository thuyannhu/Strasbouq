<?php

namespace App\Controller;

class DevisController extends AbstractController
{
    public function devis(): string
    {
        return $this->twig->render('Devis/devis.html.twig');
    }
}
