<?php

namespace App\Model;

use PDO;

class CartManager extends AbstractManager
{
    public const ORDER = 'order';
    public const PRODUCTS = 'products';
    public const USER = 'user';

    public function showCart()
    {
    }
}
