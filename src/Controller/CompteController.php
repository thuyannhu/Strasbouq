<?php

namespace App\Controller;

class CompteController extends AbstractController
{
    public function monCompte(): string
    {
        return $this->twig->render('monCompte/monCompte.html.twig');
    }
}
