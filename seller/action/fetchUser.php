<?php 	
require_once 'core.php';

$search = addslashes(trim($_GET['search']));

$sql = "SELECT DISTINCT u.username, u.fullName, u.email, u.phone, u.address, u.u_id
		FROM users u
		JOIN orders o ON u.u_id = o.user_id
		WHERE o.order_belong = '".$_SESSION['store']."'";

	if($search != "") {
		$sql .= " AND u.username LIKE '%".$search."%' OR u.fullName LIKE '%".$search."%'";
	}
	
$result = $db->query($sql);
$output = array('data' => array());

if($result->num_rows > 0) {
	$active = ""; 

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

echo json_encode($output);
