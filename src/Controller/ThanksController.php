<?php

namespace App\Controller;

class ThanksController extends AbstractController
{
    public function thanks(): string
    {
        $message = '';
        $userPrenom = $_POST['user_prenom'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userPrenom = isset($_POST['user_nom']) ? $_POST['user_nom'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $distribution = isset($_POST['distribution']) ? $_POST['distribution'] : '';

            if (!empty($userPrenom) && !empty($email) && !empty($distribution)) {
                $message = "Nous avons bien réceptionné votre demande";
            } else {
                $message = "Veuillez remplir tous les champs obligatoires.";
            }
        }

        return $this->twig->render('thanks/thanks.html.twig', ['message' => $message]);
    }
}
