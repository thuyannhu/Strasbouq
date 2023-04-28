<?php

namespace App\Controller;

use App\Model\UserManager;

class CompteController extends AbstractController
{
    public function monCompte(): string
    {
        // $_SESSION["user"]="admin@yahoo.fr";
        $email = $_SESSION["user"];

        $usermanager = new UserManager();
        $id = $usermanager->searchUser($email, "id");
        $data = $usermanager->selectOneById($id[0]['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (count($_POST) < 1) {
                $_SESSION["user"] = "";
                session_destroy();
                header('Location: /connecter');
                exit;
            }
        }





        return $this->twig->render('monCompte/monCompte.html.twig', ['data' => $data]);
    }
}
