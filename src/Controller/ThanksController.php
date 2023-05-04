<?php

namespace App\Controller;

class ThanksController extends AbstractController
{
    public function thanks(): string
    {
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = ' Merci' . $_POST['prenom'] . ' ' . $_POST['name']
                . ' de nous demander nos services pour ' . $_POST['evenement'] .
                ' avec à peu près ' . $_POST['inviter'] . ' personnes avec un thème ' . $_POST['theme'] . ' !';
            $message .= " Vous avez un budget de : " . $_POST['budget'] . " euros, pour la date du : "
                . $_POST['date'];
            $message .= " Un de nos conseillers vous contactera dans les plus brefs
             délais pour traiter votre demande ! ";
            $message .= "Et sera envoyer à " . $_POST['email'];
            $message .= " La commande sera livrée dans les plus brefs délais à l'adresse suivante : "
                . $_POST['adresse'];
            $message .= " Votre message a été pris en compte : " . $_POST['text'];
        } else {
            echo "Une erreur s'est produite lors de l'envoi de votre message. Veuillez réessayer plus tard.";
        }

        return $this->twig->render('thanks/thanks.html.twig', ['message' => $message]);
    }
}
