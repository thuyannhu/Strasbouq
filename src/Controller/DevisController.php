<?php

namespace App\Controller;

use App\Model\UserManager;
use PDO;

class DevisController extends AbstractController
{
    public function devis(): string
    {
        return $this->twig->render('Devis/devis.html.twig');
    }
}
