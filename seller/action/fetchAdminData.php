<?php 	
require_once 'core.php';

$adm_id = $_GET['userId'];

$sql = "SELECT r.title, r.email, r.phone, r.description, a.username, a.u_role
		FROM admin a
		JOIN restaurant r ON a.store = r.rs_id
		WHERE adm_id = '".$adm_id."'";

$result = $db->query($sql);

$output = array('data' => array());
if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $active = ""; 

 while($row = $result->fetch_array()) {

	

 	$output[] = array(
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