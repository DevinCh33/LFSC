<?php
// fetch_data.php

include './../connection/connect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedDate = $_POST['date'];
	
	
	if($_SESSION['adm_co'] == "SUPA"){
		$sql = "SELECT admin.*, restaurant.*, SUM(orders.total_amount) AS total 
				FROM admin 
				INNER JOIN restaurant ON admin.store = rs_id 
				LEFT JOIN orders ON admin.store = orders.order_belong 
					AND orders.order_date LIKE '$selectedDate%'
				WHERE admin.code = 'SUPP'
				GROUP BY admin.store
				ORDER BY total DESC";
	}
	else if($_SESSION['adm_co'] == "SUPP"){
		$sql = "SELECT 
            o.order_id, 
            o.order_date, 
            oi.quantity, 
            oi.price, 
            p.product_name 
        FROM orders o
        INNER JOIN order_item oi ON o.order_id = oi.order_id
        INNER JOIN product p ON oi.product_id = p.product_id
      	WHERE o.order_date LIKE '$selectedDate%' 
       			AND o.order_status = '3'";
	}
	$query = $db->query($sql);
	$response = array(); // Initialize an array to store the response data
    $htmlContent = ''; // Initialize an empty string to store HTML content
	
	if (!$query->num_rows > 0) {
		if($_SESSION['adm_co'] == "SUPA"){
			$htmlContent = '<td colspan="7"><center>No Seller-Data!</center></td>';
		}
		else{
			$htmlContent = '<td colspan="5"><center>No Order Record</center></td>';
		}
	} else {
		$totalAmount = 0;
		$no = 1;
		while ($rows = mysqli_fetch_array($query)) {
			
			if($_SESSION['adm_co'] == "SUPA"){
				if ($rows['total'] == 0) {
					$rows['total'] = 0;
				}
				$htmlContent .= '<tr>
						<td>' . $rows['username'] . '</td>
						<td>' . $rows['title'] . '</td>
						<td>' . $rows['email'] . '</td>
						<td>' . $rows['phone'] . '</td>
						<td>' . $rows['address'] . '</td>
						<td>' . $rows['total'] . '</td>
					  </tr>';
				$totalAmount += $rows['total'];
			}
			else{
				$htmlContent .= '<tr>
						<td>' . $no . '</td>
						<td>' . $rows['order_date'] . '</td>
						<td>' . $rows['product_name'] . '</td>
						<td>' . $rows['quantity'] . '</td>
						<td>' . $rows['price'] . '</td>
					  </tr>';
				++$no;
				$totalAmount += $rows['price'];
			}
			
			
		}
		
	}
	// At the end of your PHP script
	// Store data in the response array
    $response['html'] = $htmlContent;
    $response['totalAmount'] = floatval($totalAmount);

    // At the end of your PHP script
    echo json_encode($response);

}
?>
