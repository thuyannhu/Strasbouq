<?php

namespace App\Controller;

class OrderController extends AbstractController
{
    public function adminOrder()
    {
        return $this->twig->render('order/adminOrder.html.twig');
    }

    public function userOrder()
    {
        return $this->twig->render('order/userOrder.html.twig');
    }
}
