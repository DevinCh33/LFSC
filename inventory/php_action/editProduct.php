<?php 	
require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) 
{
	$productId 		= $_POST['productId'];
	$productName 	= $_POST['editProductName']; 
	$quantity 		= $_POST['editQuantity'];
	$price 			= $_POST['editPrice'];
	$categoryName 	= $_POST['editCategoryName'];
	$productStatus 	= $_POST['editProductStatus'];
		
	$sql = "UPDATE product SET product_name = '$productName', categories_id = '$categoryName', quantity = '$quantity', price = '$price', active = '$productStatus', status = 1 WHERE product_id = $productId ";

	if($db->query($sql) === TRUE) 
	{
		$valid['success'] = true;
		$valid['messages'] = "Successfully updated!";	
	} 
	
	else 
	{
		$valid['success'] = false;
		$valid['messages'] = "Error while updating product info!";
	}

} // /$_POST
	 
$db->close();

echo json_encode($valid);
