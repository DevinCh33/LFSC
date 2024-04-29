<?php
	include('../connect.php');

	$search = trim($_GET['search']);

	$query = "SELECT 
				o.order_date, p.product_name, oi.quantity, pr.proPrice, o.total_amount, u.fullName, u.u_id, o.order_status
			FROM
				orders o
			JOIN 
				order_item oi ON o.order_id = oi.order_id
			JOIN 
				tblprice pr ON oi.priceID = pr.priceNo
			JOIN 
				product p ON pr.productID = p.product_id
			JOIN 
				users u ON o.user_id = u.u_id
			WHERE
				o.order_status = 3";

		if($search != "")
			$query .= " AND u.username LIKE '%".$_GET['search']."%' OR u.fullName LIKE '%".$_GET['search']."%'";

		$query .= " ORDER BY o.order_date desc";

	$result = $db->query($query);
	$output = array('data' => array());
	$spent = 0;

	if($result->num_rows > 0) {
		while($row = $result->fetch_array()) {
			$output['data'][] = array(
				$row[0],
				$row[1],
				$row[2],
				$row[3],
				$row[4],
				$row[5],
				$row[6],
				$row[7],
			); 	
		 } // /while 

	}// if num_rows
	
	echo json_encode($output);
?>
