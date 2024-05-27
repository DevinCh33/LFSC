<?php 	
require_once 'core.php';

$pass = $_GET['pass'];

if($_SESSION['adm_co'] == "SUPA")
	$sql = "SELECT password FROM admin WHERE adm_id = '".$_SESSION['adm_id']."'";
else
	$sql = "SELECT password FROM tblemployee WHERE empID = '".$_SESSION['adm_id']."'";

$result = $db->query($sql);

if($result->num_rows > 0) { 
	
	$row = $result->fetch_array();
	
	if (password_verify($pass, $row[0])) {
    	$output = 1;
  	} else {
    	$output = 0;
    }

}// if num_rows

echo json_encode($output);