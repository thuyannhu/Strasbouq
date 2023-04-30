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
        // if (isset($_SESSION['cart']))
        $id = $_SESSION['cart']['id'];
        var_dump($_SESSION['cart']);
        var_dump($id);
        unset($_SESSION['cart'][$id]);
        header('Location: /cart');
        exit();
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
