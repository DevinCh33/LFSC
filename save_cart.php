<?php
session_start();
include("config/cart.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['cart']))
    {
        $valid = True;

        foreach ($_POST['cart'] as $item)
        {
            $priceInDB = (float)$_SESSION['PWS']['prices'][$item['price_id']];
            $weightInDB = (int)$_SESSION['PWS']['weights'][$item['price_id']];
            $stockInDB = (int)$_SESSION['PWS']['stock'][$item['price_id']];
            $itemPrice = (float)$item['price'];
            $itemWeight = (float)$item['weight'];
            $itemStock = (int)$item['stock'];

            if ($itemPrice <= $priceInDB/$divideMinPrice)
            {
                $valid = False;
                break;
            }

            if ($itemWeight <= $weightInDB/$divideMinWeight)
            {
                $valid = False;
                break;
            }

            if ($itemStock/$divideMaxStock >= $stockInDB)
            {
                $valid = False;
                break;
            }
        }

        if ($valid) // If prices were not altered
        {
            $_SESSION['cart'] = $_POST['cart'];
        }
    }

    else
    {
        // In the case of empty cart
        unset($_SESSION['cart']);
    }
}

elseif(isset($_SESSION['cart'])) 
{
    $cart = $_SESSION['cart'];

    // Return cart as JSON response
    header('Content-Type: application/json');

    // Make sure numbers remain numbers in JSON
    echo json_encode($cart, JSON_NUMERIC_CHECK);
}
