<?php 

require_once 'core.php';

	$pass = $_GET['newPass'];

	$newPassword = password_hash($pass, PASSWORD_DEFAULT);
	$valid = "";
	
	$updateSql = "UPDATE admin SET password = '$newPassword' WHERE adm_id = '".$_SESSION['adm_id']."'";
	if($db->query($updateSql) === TRUE) {
		$valid = "PASSWORD UPDATED";		
	} else {
		$valid = "UPDATED FAILED";	
	}


	echo json_encode($valid);



?>