<?php

namespace App\Controller;

class ThanksController extends AbstractController
{
    public function thanks(): string
    {
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = ' Merci de nous demander nos services pour ' . $_POST['evenement'] .
                ' avec à peu près ' . $_POST['inviter'] . ' personnes avec un thème ' . $_POST['theme'] . ' !';
            $message .= " Vous avez un budget de : " . $_POST['budget'] . " euros, pour la date du : "
                . $_POST['date'];
            $message .= " Un de nos conseillers vous contactera dans les plus brefs
             délais pour traiter votre demande ! ";
            $message .= " La commande sera livrée dans les plus brefs délais à l'adresse suivante : "
                . $_POST['adresse'];
            $message .= " Votre message a été pris en compte : " . $_POST['text'];
        }

        return $this->twig->render('thanks/thanks.html.twig', ['message' => $message]);
    }
}
