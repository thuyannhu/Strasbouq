<?php

namespace App\Controller;

class CompteController extends AbstractController
{
    public function MonCompte(): string
    {
        return $this->twig->render('monCompte/monCompte.html.twig');
    }
}