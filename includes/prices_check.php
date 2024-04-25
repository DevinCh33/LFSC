<?php

class PricesCheck {
	public $Dictionary;

	function Refresh($db)
	{
		$this->Dictionary = [];

		$query = "SELECT tblprice.priceNo, tblprice.proPrice, tblprice.proDisc, tblprice.proQuant from product JOIN tblprice ON product.product_id = tblprice.productID";
		$products = mysqli_query($db, $query); // executing
		
		if (!empty($products)) 
		{
			foreach($products as $product)
			{   
				$this->Dictionary['prices'][$product['priceNo']] = $product['proPrice'];
				$this->Dictionary['discount'][$product['priceNo']] = $product['proDisc'];
				$this->Dictionary['stock'][$product['priceNo']] = $product['proQuant'];
			}
		}
	}
}
