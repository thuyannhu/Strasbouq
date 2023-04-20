<?php

namespace App\Controller;

class ConnecterController extends AbstractController
{
    public function connect(): string
    {
        $message = "";
        $alert = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (count($_POST) < 3) {
                $username = $_POST["email"];
                $database = ['seeboutiquedvd@sfr.fr' => '070704'];
                if (isset($database[$username])) {
                    if ($_POST["password"] === $database[$username]) {
                        $message = "vous etes connecté!";
                        $alert = 'success';
                    } else {
                        $message = "erreur!! mot de passe erroné";
                        $alert = 'danger';
                    }
                } else {
                    $message = "erreur!! email inconnu";
                    $alert = 'danger';
                }
            } else {
            }
        }
        return $this->twig->render('Connecter/connect.html.twig', ['message' => $message, 'alert' => $alert]);
    }
}
