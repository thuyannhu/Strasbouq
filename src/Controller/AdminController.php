<?php

namespace App\Controller;

class AdminController extends AbstractController
{
    public function admin()
    {
        return $this->twig->render('Admin/admin.html.twig');
    }
}
