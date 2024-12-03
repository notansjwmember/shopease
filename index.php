<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/api/products':
        include 'api/products.php';
        break;
    case '/api/orders':
        include 'api/orders.php';
        break;
    case '/api/customer':
        include 'api/customer.php';
        break;
    default:
        echo "404 Not Found";
        break;
}
?>
