<?php

namespace App\Controller;

class CartController extends AbstractController
{
    public function clearCart()
    {
        // Supprime les données de la session relatives au panier
        unset($_SESSION['cart']);
        header('Location: /cart');
        exit();
    }

    public function clearProduct()
    {
        // Supprime les données de la session relatives à un produit
        $id = $_GET['id'];
        unset($_SESSION['cart'][$id]);
        header('Location: /cart');
        exit();
    }

    public function cart(): string
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        return $this->twig->render('Cart/cart.html.twig', ['cart' => $_SESSION['cart']]);
    }
}
