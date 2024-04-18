<?php

function obtainPWSDictionary($db)
{
	$PWSDictionary = [];
	$query = "SELECT tblprice.priceNo, tblprice.proPrice, tblprice.proWeight, product.quantity from product JOIN tblprice ON product.product_id = tblprice.productID";
	$products = mysqli_query($db, $query); // executing
	
	if (!empty($products)) 
	{
		foreach($products as $product)
		{   
			$PWSDictionary['prices'][$product['priceNo']] = $product['proPrice'];
			$PWSDictionary['weights'][$product['priceNo']] = $product['proWeight'];
			$PWSDictionary['stock'][$product['priceNo']] = $product['quantity'];
		}
	}

	$_SESSION['PWS'] = $PWSDictionary;
}
