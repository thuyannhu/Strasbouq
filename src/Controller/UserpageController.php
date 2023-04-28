<?php

namespace App\Controller;

use App\Model\UserManager;

class UserpageController extends AbstractController
{
    public function userpage(): string
    {
        $userManager = new UserManager();
        $userData = $userManager->selectAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST["id"];
            $userManager->deleteUser($id);
            header('Location: /userpage');
            exit;
        }
        return $this->twig->render('userpage/userpage.html.twig', ['data' => $userData]);
    }
}
