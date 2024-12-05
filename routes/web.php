<?php

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_path = '/shopease/';
$request = str_replace($base_path, '/', $request);

include 'pages/shared/header.php';

switch ($request) {
  case '/':
    include 'pages/home.php';
    break;
  
  case '/login':
    include 'pages/login.php';
    break;
  
  case '/register':
    include 'pages/register.php';
    break;

  case '/products':
    include 'pages/products.php';
    break;

  case '/orders':
    include 'pages/orders.php';
    break;

  default:
    include 'pages/404.php';
    break;
}

include 'pages/shared/footer.php';
