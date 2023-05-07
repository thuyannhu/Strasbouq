<?php

namespace App\Controller;

use App\Model\UserManager;

class UserpageController extends AbstractController
{
    public function userpage(): string
    {
        $userManager = new UserManager();
        $client = $userManager->searchUser($_SESSION["user"], "isAdmin");

        if ($client != 1) { // si l'utilisateur n'est pas admin
            header('Location: /');
            exit;
        } else {
            $userData = $userManager->selectAll();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST["id"];
                $userManager->deleteUser($id);
                header('Location: /userpage');
                exit;
            }
            return $this->twig->render('userpage/userpage.html.twig', ['data' => $userData, "client" => $client]);
        }
    }
}
