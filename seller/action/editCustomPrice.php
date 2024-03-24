<?php 	
require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) 
{	
	$user_id 		= $_POST['user'];
	$product_id 	= $_POST['productID']; 
	$price 	        = $_POST['price'];

    $sql = "SELECT * FROM custom_prices WHERE product_id = ".$product_id." AND user_id = ".$user_id;
    
    if (count($db->query($sql)->fetch_all()) == 1) {
        $sql = "UPDATE custom_prices SET price = ".$price." WHERE product_id = ".$product_id." AND user_id = ".$user_id;
    }

    else {
        $sql = "INSERT INTO custom_prices(user_id, product_id, price) VALUES($user_id, $product_id, $price)";
    }

	if($db->query($sql) === TRUE) 
	{
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Updated";	
	} 
	
	else 
	{
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while updating the categories";
	}
	 
	$db->close();

	echo json_encode($valid);
} // /if $_POST