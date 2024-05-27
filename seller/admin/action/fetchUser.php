<?php 	
require_once 'core.php';

$sql = "SELECT u.username, u.fullName, u.email, u.phone, u.address, u.u_id, u.status
		FROM users u";

if($_GET['search'] != ""){
	$sql .= " WHERE u.username LIKE '%".$_GET['search']."%' OR u.email LIKE '%".$_GET['search']."%' or u.fullName  LIKE '%".$_GET['search']."%'";
}

$result = $db->query($sql);

$output = array('data' => array());
if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $active = ""; 

 while($row = $result->fetch_array()) {

	

 	$output['data'][] = array(
		$row[0],
		$row[1],
		$row[2],
		$row[3],
		$row[4],
		$row[5],
		$row[6]
 	); 	
 } // /while 

}// if num_rows

echo json_encode($output);