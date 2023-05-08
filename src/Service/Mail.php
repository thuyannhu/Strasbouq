<?php

namespace App\Service;

class Mail
{
    public function mailOrder($orderNumber, $products)
    {
        $adminMail = "benjyzilliox@hotmail.com";
        $subject = "Commande n° " . $orderNumber;
        $message = "Bonjour, une nouvelle commande est arrivée. 
                    Vous pouvez la consulter sur la page de gestion de commande.<br>";
        $message .= "Voici le détail de la commande : <br>" . $products;

        $headers = "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From:lunacode@gmail.com\r\n";

        return mail($adminMail, $subject, $message, $headers);
    }
}
