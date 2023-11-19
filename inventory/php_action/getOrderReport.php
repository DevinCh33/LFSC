<?php 
require_once 'core.php';

if($_POST) 
{
	
	$startDate = strtotime($_POST['startDate']);
	$start_date = date("Y-m-d", $startDate);

	$endDate = strtotime($_POST['endDate']);
	$end_date = date("Y-m-d", $endDate);

	$sql = "SELECT * FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' AND order_status = '3'";
	$query = $db->query($sql);
	$table = '<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
			<th>No</th>
			<th>Order Date</th>
			<th>Product Name</th>
			<th>Quantity</th>
			<th>Price</th>
		</tr>
		<tr>';
	
		$totalAmount = 0;
		while ($result = $query->fetch_assoc()) {
			$product = "SELECT oi.quantity,oi.price, p.product_name FROM order_item oi
                       INNER JOIN product p ON oi.product_id = p.product_id
                       WHERE order_id = '".$result['order_id']."'";
			$product1 = $db->query($product);
			$no = 1;
			while($product2 = $product1->fetch_assoc()){
				$table .= '<tr>
					<td><center>'.$no.'</center></td>
					<td><center>'.$result['order_date'].'</center></td>
					<td><center>'.$product2['product_name'].'</center></td>
					<td><center>'.$product2['quantity'].'</center></td>
					<td><center>'.$product2['price'].'</center></td>
				</tr>';	
				$totalAmount = $totalAmount + $product2['quantity'] * $product2['price'];
				++$no;
			}
		}
		$table .= '
		</tr>
		<tr>
			<td colspan="4"><center>Total Amount</center></td>
			<td><center>'.$totalAmount.'</center></td>
		</tr>
	</table>
	';	

	echo $table;
}

?>