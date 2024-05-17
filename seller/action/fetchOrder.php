<?php 	

include("../connect.php");

$order = addslashes($_GET['search']);

$sql = "SELECT order_id, client_name, client_contact,  order_date,  payment_type ,order_status FROM orders WHERE order_status = 1 AND order_belong = '".$_SESSION['store']."'";

if($order != ""){
	$sql .= " AND order_id = '".$order."'";
}

$result = $db->query($sql);
$output = array('data' => array());

if($result->num_rows > 0) { 
	while($row = $result->fetch_array()) {
		$type="";
		if($row[4] == "1")
			$type = "CASH ON DELIVERY";
		else if($row[4] == "2")
			$type = "SARAWAK PAY";
		else if($row[4] == "3")
			$type = "PayPal";
		 
		$output['data'][] = array(
			$row[0], 
			$row[1], 
			$row[2], 
			$row[3], 
			$type, 
			$row[5]
		); 	
	 } // /while 

}// if num_rows

$db->close();

echo json_encode($output);
