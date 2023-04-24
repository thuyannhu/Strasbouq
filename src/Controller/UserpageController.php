<?php

namespace App\Controller;

use App\Model\UserManager;

class UserpageController extends AbstractController
{
    public function userpage(): string
    {
        $userManager = new UserManager();
        $userData = $userManager->selectAll();
        return $this->twig->render('userpage/userpage.html.twig', ['data' => $userData]);
    }
}
