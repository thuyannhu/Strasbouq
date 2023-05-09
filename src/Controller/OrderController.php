<?php

namespace App\Controller;

use App\Model\OrderManager;
use App\Service\Mail;
use App\Model\UserManager;

class OrderController extends AbstractController
{
    public function addOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userMail = $_POST['user'];
            $price = $_POST['price'];
            $orderManager = new OrderManager();

            $orderNumber = uniqid();
            $orderManager->insertOrder($orderNumber, $userMail, $price);

            // envoi d'un mail à l'admin
            $mail = new Mail();
            $orderNumber = $orderManager->getLastInsertedOrderNumber();
            $products = "";
            foreach ($_SESSION['cart'] as $product) {
                $products .= "- " . $product['name'] . " x " . $product['quantity'] . "<br>";
            }
            $mail->mailOrder($orderNumber, $products);

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

            if ($_POST['status'] == "terminé") {
                $userMail = "";
                $prix = 0;
                $orders = $orderManager->showAllOrder();
                foreach ($orders as $order) {
                    if ($order['id'] == $id) {
                        $prix = $order['price'];
                        $userMail = $order['mail'];
                    }
                }
                $userManager = new UserManager();
                $fidelity = $userManager->searchUser($userMail, "fidelity");
                $ide = $userManager->searchUser($userMail, "id");
                $userManager->modifyUser("fidelity", $fidelity + $prix, $ide);
            }
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
