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

    public function updateOrderStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $orderManager = new OrderManager();
            $orderManager->updateOrderStatus($id, $status);
            header('Location: /adminOrder');
            exit;
        }
    }

    public function deleteOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $orderManager = new OrderManager();
            $orderManager->deleteOrder($id);
            header('Location: /adminOrder');
            exit;
        }
    }

    public function adminOrder()
    {
        $orderManager = new OrderManager();
        $orders = $orderManager->showAllOrder();
        return $this->twig->render('order/adminOrder.html.twig', ['orders' => $orders]);
    }

    public function userOrder()
    {
        $orderManager = new OrderManager();
        $orders = $orderManager->showOrderByUser($_SESSION['user']);
        return $this->twig->render('order/userOrder.html.twig', ['orders' => $orders]);
    }
}
