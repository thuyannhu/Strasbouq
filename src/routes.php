<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['HomeController', 'index',],
    'contact' => ['ContactController', 'index',],
    'nosBouquets' => ['BouquetsController', 'nosBouquets',],
    'products' => ['ProductController', 'index',],
    'products/edit' => ['ProductController', 'edit', ['id']],
    'products/show' => ['ProductController', 'show', ['id']],
    'products/showsheet' => ['ProductController', 'showsheet', ['id']],
    'products/add' => ['ProductController', 'add',],
    'products/delete' => ['ProductController', 'delete',],
    'userpage' => ['UserpageController', 'userpage',],
    'connecter' => ['ConnecterController', 'connect',],
    'devis' => ['DevisController', 'devis',],
    'admin' => ['AdminController', 'admin',],
    'monCompte' => ['CompteController', 'moncompte',],
    'cart' => ['CartController', 'cart',],
    'cart/clearCart' => ['CartController', 'clearCart',],
    'legal' => ['LegalController', 'legal',],
    'cart/clearProduct' => ['CartController', 'clearProduct',],
    'order/addOrder' => ['OrderController', 'addOrder',],
    'order/updateOrderStatus' => ['OrderController', 'updateOrderStatus',],
    'order/deleteOrder' => ['OrderController', 'deleteOrder',],
    'adminOrder' => ['OrderController', 'adminOrder',],
    'userOrder' => ['OrderController', 'userOrder',],
    'flower' => ['FlowerController', 'flowers',],
];
