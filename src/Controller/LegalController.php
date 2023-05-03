<?php

namespace App\Controller;

class LegalController extends AbstractController
{
    /**
     * Display home page
     */
    public function legal(): string
    {
        return $this->twig->render('Legal/legal.html.twig');
    }
}
