<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopease</title>

    <!-- always include this style in every page -->
    <link rel="stylesheet" href="/css/style.css">

    <!-- styles depending on the page -->
    <?php if (!empty($page)) : ?>
        <link rel="stylesheet" href="/css/<?php echo $page; ?>.css">
    <?php endif; ?>

</head>

<!-- of course we need the navbar -->
<?php
include 'components/navbar.php';
?>

<body>