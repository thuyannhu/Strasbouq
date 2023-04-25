<?php

namespace App\Controller;

class CartController extends AbstractController
{
    public function cart(): string
    {
        return $this->twig->render('Cart/cart.html.twig');
    }
}
