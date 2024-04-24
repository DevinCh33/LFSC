<?php

class PricesCheck {
	private $Database;
	public $Dictionary;

	function __construct($db)
	{
		$this->Database = $db;
	}

	function Refresh()
	{
		$this->Dictionary = [];

		$query = "SELECT tblprice.priceNo, tblprice.proPrice, tblprice.proQuant from product JOIN tblprice ON product.product_id = tblprice.productID";
		$products = mysqli_query($this->Database, $query); // executing
		
		if (!empty($products)) 
		{
			foreach($products as $product)
			{   
				$this->Dictionary['prices'][$product['priceNo']] = $product['proPrice'];
				$this->Dictionary['stock'][$product['priceNo']] = $product['proQuant'];
			}
		}
	}
}
