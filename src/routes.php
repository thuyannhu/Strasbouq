<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['HomeController', 'index',],
    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
    'contact' => ['ContactController', 'index',],
    'nosBouquets' => ['BouquetsController', 'nosBouquets',],
    'products' => ['ProductController', 'index',],
    'products/edit' => ['ProductController', 'edit', ['id']],
    'products/show' => ['ProductController', 'show', ['id']],
    'products/add' => ['ProductController', 'add',],
    'products/delete' => ['ProductController', 'delete',],
    'userpage' => ['UserpageController', 'userpage',],
    'connecter' => ['ConnecterController','connect',],
    'devis' => ['DevisController', 'devis',],
    'admin' => ['AdminController', 'admin',],
    'cart' => ['CartController', 'cart',],
    'cart/clearCart' => ['CartController', 'clearCart',],
];
