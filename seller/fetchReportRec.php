<?php
// fetch_data.php

include './../connection/connect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedDate = $_POST['date'];
	
	
	if($_SESSION['adm_co'] == "SUPA"){
		$sql = "SELECT admin.username, restaurant.*, SUM(orders.total_amount) AS total 
				FROM admin 
				INNER JOIN restaurant ON admin.store = rs_id 
				LEFT JOIN orders ON admin.store = orders.order_belong 
					AND orders.order_date LIKE '$selectedDate%' AND orders.order_status = '3'
				WHERE admin.code = 'SUPP' 
				GROUP BY admin.store
				ORDER BY total DESC";
	}
	else if($_SESSION['adm_co'] == "SUPP"){
		$sql = "SELECT
					oi.product_id,
					SUM(oi.quantity) AS total_quantity,
					SUM(oi.total) AS total_price,
					p.product_name
				FROM
					orders o
				INNER JOIN order_item oi ON o.order_id = oi.order_id
				INNER JOIN product p ON p.product_id = oi.product_id
				WHERE
					o.order_date LIKE '".$selectedDate."%'
					AND o.order_belong = '".$_SESSION['store']."'
				GROUP BY
					oi.product_id;";
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
						<td>
                       		<i class="fa fa-file-text-o btn btn-primary" aria-hidden="true" onclick="generateReceipt('.$rows['rs_id'].')"></i>
                        </td>
					  </tr>';
				$totalAmount += $rows['total'];
			}
			else{
				$htmlContent .= '<tr>
						<td>' . $no . '</td>
						<td>' . $rows['product_name'] . '</td>
						<td>' . $rows['total_quantity'] . '</td>
						<td>' . $rows['total_price'] . '</td>
					  </tr>';
				++$no;
				$totalAmount += $rows['total_price'];
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
