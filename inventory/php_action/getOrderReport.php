<?php 
require_once 'core.php';

if($_POST) {
	$startDate = strtotime($_POST['startDate']);
	$start_date = date("Y-m-d h:i:s", $startDate);

	$endDate = strtotime($_POST['endDate']);
	$end_date = date("Y-m-d h:i:s", $endDate);

	$sql = "SELECT * FROM users_orders WHERE date >= '$start_date' AND date <= '$end_date' AND status = 'closed'";
	$query = $connect->query($sql);
	
	$table = '<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
			<th>Order Date</th>
			<th>Product Name</th>
			<th>Quantity</th>
			<th>Price</th>
		</tr>
		<tr>';
		$totalAmount = 0;
		while ($result = $query->fetch_assoc()) {
			$table .= '<tr>
				<td><center>'.$result['date'].'</center></td>
				<td><center>'.$result['title'].'</center></td>
				<td><center>'.$result['quantity'].'</center></td>
				<td><center>'.$result['price'].'</center></td>
			</tr>';	
			$totalAmount = $totalAmount + $result['quantity'] * $result['price'];
		}
		$table .= '
		</tr>
		<tr>
			<td colspan="3"><center>Total Amount</center></td>
			<td><center>'.$totalAmount.'</center></td>
		</tr>
	</table>
	';	

	echo $table;

}

?>