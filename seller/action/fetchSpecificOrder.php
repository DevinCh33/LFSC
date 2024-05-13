<?php 	

include("../connect.php");

$order = $_GET['search'];

$sql = "SELECT o.order_id,o.client_name, o.client_contact, tp.product_name, oi.quantity, t.proPrice
		FROM orders o
		JOIN 
			order_item oi ON o.order_id = oi.order_id
		JOIN
			tblprice t ON oi.priceID = t.priceNo
		JOIN
			product tp ON t.productID = tp.product_id
		WHERE o.order_status = 1 AND o.order_belong = '".$_SESSION['store']."'";

if($order != ""){
	$sql .= " AND o.order_id = '".$order."'";
}

$result = $db->query($sql);
$output = array('data' => array());

if($result->num_rows > 0) { 

	 while($row = $result->fetch_array()) {
		 
		 $output['data'][] = array(
			$row[0], 
			$row[1], 
			$row[2], 
			$row[3], 
			$row[4],
			$row[5]
		); 	
	 } // /while 

}// if num_rows

$db->close();

echo json_encode($output);