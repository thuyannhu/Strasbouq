<?php

namespace App\Controller;

class HistoriqueController extends AbstractController
{
    public function historique(): string
    {
        return $this->twig->render('historique/historique.html.twig');
    }
}
