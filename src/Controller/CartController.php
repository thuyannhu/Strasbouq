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
        if (isset($_GET['productId'])) {
            $productId = $_GET['productId'];
            // Supprime les données de la session relatives à un produit
            if (isset($_SESSION['cart'][$productId])) {
                unset($_SESSION['cart'][$productId]);
            }

            // Redirige l'utilisateur en fonction de la page actuelle
            if (strpos($_SERVER['HTTP_REFERER'], '/cart') !== false) {
                header('Location: /cart');
            } elseif (strpos($_SERVER['HTTP_REFERER'], '/flower') !== false) {
                header('Location: /flower');
            } else {
                header('Location: /');
            }
            exit();
        }
    }

    public function cart(): string
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        return $this->twig->render('Cart/cart.html.twig', ['cart' => $_SESSION['cart'], 'user' => $_SESSION['user']]);
    }
}
