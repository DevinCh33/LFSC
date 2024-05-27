<?php 	
require_once 'core.php';

$pass = $_GET['email'];

$sql = "SELECT empemail FROM tblemployee WHERE empstatus = '1' AND empemail = '$pass'";

$result = $db->query($sql);

if($result->num_rows > 0) { 
	$output = 1;
}
else{
	$output = 0;
}

echo json_encode($output);