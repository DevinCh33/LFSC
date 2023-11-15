<?php
session_start();

if (isset($_POST['cart']))
{
    $_SESSION['cart'] = $_POST['cart'];
}

elseif(isset($_SESSION['cart'])) 
{
    $cart = $_SESSION['cart'];

    // Return cart as JSON response
    header('Content-Type: application/json');

    // Make sure numbers remain numbers in JSON
    echo json_encode($cart, JSON_NUMERIC_CHECK);
}
?>