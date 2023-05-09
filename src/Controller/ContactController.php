<?php

namespace App\Controller;

use App\Service\Mail;

class ContactController extends AbstractController
{
    public function index(): string
    {
        $retour = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mailService = new Mail();
            $retour = $mailService->envoiMail(
                $_POST['nom'],
                $_POST['email'],
                "nhu.thuy.an@gmail.com",
                'Service client',
                $_POST['email'] . " - " . $_POST['sujet'],
                $_POST['message']
            );
        }
        return $this->twig->render('Contact/index.html.twig', ['retour' => $retour]);
    }
}
