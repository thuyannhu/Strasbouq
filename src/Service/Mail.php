<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    // nom de l'expéditeur, email de l'expéditeur, email de destination, nom du destinataire, sujet du mail, message
    public function envoiMail($fromName, $fromEmail, $destEmail, $destName, $subject, $message)
    {

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPSecure = 'ssl';
        $mail->Host      = 'smtp.gmail.com';
        $mail->SMTPAuth  = true;
        $mail->Username  = "dubois.ethan77@gmail.com";
        $mail->Password  = "kdjjrvefmvnxnbxh";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port      = 465;

        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($destEmail, $destName);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->setLanguage('fr');

        return $mail->send();
    }

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
