<?php

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_path = '/shopease/';
$request = str_replace($base_path, '/', $request);

$page = '';

switch ($request) {
  case '/':
    $page = 'home';
    include 'components/header.php';
    include 'pages/home.php';
    break;

  case '/products':
    $page = 'products';
    include 'components/header.php';
    include 'pages/products.php';
    break;

  default:
    $page = '404';
    include 'components/header.php';
    include 'pages/404.php';
    break;
}

include 'components/footer.php';
