<?php
include("includes/prices_check.php");
include("config/cart.php");
include("config/connect.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['cart']))
    {
        $valid = True;

        foreach ($_POST['cart'] as $item)
        {
            if ($refreshBeforeCheck)
            {
                $_SESSION['pricesCheck']->Refresh($db);
            }

            $priceInDB = (float)$_SESSION['pricesCheck']->Dictionary['prices'][$item['price_id']];
            $stockInDB = (int)$_SESSION['pricesCheck']->Dictionary['stock'][$item['price_id']];
            $discountInDB = (float)$_SESSION['pricesCheck']->Dictionary['discount'][$item['price_id']];
            $itemPrice = (float)$item['price'];
            $itemStock = (int)$item['stock'];

            if (($exactPriceCheck) && (abs($itemPrice - $priceInDB*(1-$discountInDB/100)) > 0.001))
            {
                $valid = False;
                break;
            }

            elseif ((!$exactPriceCheck) && ($itemPrice <= $priceInDB/$divideMinPrice))
            {
                $valid = False;
                break;
            }

            if ($itemStock/$divideMaxStock > $stockInDB)
            {
                $valid = False;
                break;
            }
        }

        if ($valid) // If everything checks out
        {
            $_SESSION['cart'] = $_POST['cart'];
        }

        else
        {
            echo json_encode("Error: Detected");
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
