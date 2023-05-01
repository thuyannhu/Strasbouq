<?php

namespace App\Controller;

use App\Model\OrderManager;

class OrderController extends AbstractController
{
    public function addOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userMail = $_POST['user'];
            $price = $_POST['price'];
            $orderManager = new OrderManager();

            $orderManager->insertOrder($userMail, $price);

            header('Location: /userOrder');
            exit;
        }
    }

    public function adminOrder()
    {
        return $this->twig->render('order/adminOrder.html.twig');
    }

    public function userOrder()
    {
        return $this->twig->render('order/userOrder.html.twig');
    }
}
