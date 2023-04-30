<?php

namespace App\Controller;

class CartController extends AbstractController
{
    public function clearCart()
    {
        // Supprime les données de la session relatives au panier
        session_unset();
        unset($_SESSION['cart']);
        header('Location: /cart');
        exit();
    }

    public function clearProduct()
    {
        if (isset($_GET['productId'])) {
            $productId = $_GET['productId'];
            // Supprime les données de la session relatives à un produit
            if (isset($_SESSION['cart'][$productId])) {
                unset($_SESSION['cart'][$productId]);
            }
            header('Location: /cart');
            exit();
        }
    }

    public function cart(): string
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        var_dump($_SESSION);
        return $this->twig->render('Cart/cart.html.twig', ['cart' => $_SESSION['cart']]);
    }
}
