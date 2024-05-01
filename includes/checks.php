<?php

class DuplicateCheck {
    private $Array = array();

    function Add($id)
    {
        if ($id != null)
        {
            $this->Array[count($this->Array)] = $id;
        }
    }

    function List()
    {
        $string = "(";

        foreach ($this->Array as $id)
        {
            $string = $string.$id.",";
        }

        $string[strlen($string) - 1] = ")";

        return $string;
    }
}

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
